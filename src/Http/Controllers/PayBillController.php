<?php

namespace Fintech\Tab\Http\Controllers;

use Exception;
use Fintech\Auth\Facades\Auth;
use Fintech\Core\Enums\Auth\RiskProfile;
use Fintech\Core\Enums\Auth\SystemRole;
use Fintech\Core\Enums\Transaction\OrderStatus;
use Fintech\Core\Enums\Transaction\OrderType;
use Fintech\Core\Exceptions\DeleteOperationException;
use Fintech\Core\Exceptions\RestoreOperationException;
use Fintech\Core\Exceptions\StoreOperationException;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Tab\Http\Requests\ImportPayBillRequest;
use Fintech\Tab\Http\Requests\IndexPayBillRequest;
use Fintech\Tab\Http\Requests\StorePayBillRequest;
use Fintech\Tab\Http\Requests\UpdatePayBillRequest;
use Fintech\Tab\Http\Resources\PayBillCollection;
use Fintech\Tab\Http\Resources\PayBillResource;
use Fintech\Transaction\Facades\Transaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Class PayBillController
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to PayBill
 *
 * @lrd:end
 */
class PayBillController extends Controller
{
    /**
     * @lrd:start
     * Return a listing of the *PayBill* resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     *
     * @lrd:end
     */
    public function index(IndexPayBillRequest $request): PayBillCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();
            // $inputs['transaction_form_id'] =transaction()->transactionForm()->findWhere(['code' => 'bill_payment'])->getKey();
            $inputs['transaction_form_code'] = 'bill_payment';
            // $inputs['service_id'] = business()->serviceType()->list(['service_type_slug'=>'bill_payment']);
            // $inputs['service_type_slug'] = 'bill_payment';
            $payBillPaginate = tab()->payBill()->list($inputs);

            return new PayBillCollection($payBillPaginate);

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Create a new *PayBill* resource in storage.
     *
     * @lrd:end
     */
    public function store(StorePayBillRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();
            if ($request->input('user_id') > 0) {
                $user_id = $request->input('user_id');
            }
            $depositor = $request->user('sanctum');
            if (Transaction::orderQueue()->addToQueueUserWise(($user_id ?? $depositor->getKey())) > 0) {
                $depositAccount = transaction()->userAccount()->findWhere(['user_id' => $user_id ?? $depositor->getKey(), 'country_id' => $request->input('source_country_id', $depositor->profile?->country_id)]);

                if (! $depositAccount) {
                    throw new Exception("User don't have account deposit balance");
                }

                $masterUser = Auth::user()->findWhere(['role_name' => SystemRole::MasterUser->value, 'country_id' => $request->input('source_country_id', $depositor->profile?->country_id)]);

                if (! $masterUser) {
                    throw new Exception('Master User Account not found for '.$request->input('source_country_id', $depositor->profile?->country_id).' country');
                }

                // set pre defined conditions of deposit
                $inputs['transaction_form_id'] = transaction()->transactionForm()->findWhere(['code' => 'bill_payment'])->getKey();
                $inputs['user_id'] = $user_id ?? $depositor->getKey();
                $delayCheck = transaction()->order()->transactionDelayCheck($inputs);
                if ($delayCheck['countValue'] > 0) {
                    throw new Exception('Your Request For This Amount Is Already Submitted. Please Wait For Update');
                }
                $inputs['sender_receiver_id'] = $masterUser->getKey();
                $inputs['is_refunded'] = false;
                $inputs['status'] = OrderStatus::Pending->value;
                $inputs['risk'] = RiskProfile::Low->value;
                $inputs['reverse'] = true;
                $inputs['order_data']['currency_convert_rate'] = business()->currencyRate()->convert($inputs);
                unset($inputs['reverse']);
                $inputs['converted_amount'] = $inputs['order_data']['currency_convert_rate']['converted'];
                $inputs['converted_currency'] = $inputs['order_data']['currency_convert_rate']['output'];
                $inputs['order_data']['created_by'] = $depositor->name;
                $inputs['order_data']['created_by_mobile_number'] = $depositor->mobile;
                $inputs['order_data']['created_at'] = now();
                $inputs['order_data']['master_user_name'] = $masterUser['name'];
                // $inputs['order_data']['operator_short_code'] = $request->input('operator_short_code', null);
                $inputs['order_data']['system_notification_variable_success'] = 'bill_payment_success';
                $inputs['order_data']['system_notification_variable_failed'] = 'bill_payment_failed';
                $inputs['order_data']['order_type'] = OrderType::BillPayment;
                unset($inputs['pin'], $inputs['password']);

                $payBill = tab()->payBill()->create($inputs);

                if (! $payBill) {
                    throw (new StoreOperationException)->setModel(config('fintech.tab.pay_bill_model'));
                }
                $order_data = $payBill->order_data;
                $order_data['purchase_number'] = entry_number($payBill->getKey(), $payBill->sourceCountry->iso3, OrderStatus::Successful->value);
                $order_data['service_stat_data'] = business()->serviceStat()->serviceStateData($payBill);
                // TODO Need to work negative amount
                $order_data['user_name'] = $payBill->user->name;
                $payBill->order_data = $order_data;
                $userUpdatedBalance = tab()->payBill()->debitTransaction($payBill);
                $depositedAccount = transaction()->userAccount()->findWhere(['user_id' => $depositor->getKey(), 'country_id' => $payBill->source_country_id]);
                // update User Account
                $depositedUpdatedAccount = $depositedAccount->toArray();
                $depositedUpdatedAccount['user_account_data']['spent_amount'] = (float) $depositedUpdatedAccount['user_account_data']['spent_amount'] + (float) $userUpdatedBalance['spent_amount'];
                $depositedUpdatedAccount['user_account_data']['available_amount'] = (float) $userUpdatedBalance['current_amount'];
                if (((float) $depositedUpdatedAccount['user_account_data']['available_amount']) < ((float) config('fintech.transaction.minimum_balance'))) {
                    throw new Exception(__('Insufficient balance!', [
                        'previous_amount' => ((float) $depositedUpdatedAccount['user_account_data']['available_amount']),
                        'current_amount' => ((float) $userUpdatedBalance['spent_amount']),
                    ]));
                }
                $order_data['order_data']['previous_amount'] = (float) $depositedAccount->user_account_data['available_amount'];
                $order_data['order_data']['current_amount'] = (float) $userUpdatedBalance['current_amount'];
                if (!transaction()->userAccount()->update($depositedAccount->getKey(), $depositedUpdatedAccount)) {
                    throw new Exception(__('User Account Balance does not update', [
                        'previous_amount' => ((float) $depositedUpdatedAccount['user_account_data']['available_amount']),
                        'current_amount' => ((float) $userUpdatedBalance['spent_amount']),
                    ]));
                }
                tab()->payBill()->update($payBill->getKey(), ['order_data' => $order_data, 'order_number' => $order_data['purchase_number']]);
                transaction()->orderQueue()->removeFromQueueUserWise($user_id ?? $depositor->getKey());
                DB::commit();

                return response()->created([
                    'message' => __('core::messages.resource.created', ['model' => 'Pay Bill']),
                    'id' => $payBill->getKey(),
                    'spent' => $userUpdatedBalance['spent_amount'],
                    'order_number' => $payBill->order_number ?? $payBill->order_data['purchase_number'],
                ]);
            } else {
                throw new Exception('Your another order is in process...!');
            }
        } catch (Exception $exception) {
            transaction()->orderQueue()->removeFromQueueUserWise($user_id ?? $depositor->getKey());
            DB::rollBack();

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Update a specified *PayBill* resource using id.
     *
     * @lrd:end
     */
    public function update(UpdatePayBillRequest $request, string|int $id): JsonResponse
    {
        try {

            $payBill = tab()->payBill()->find($id);

            if (! $payBill) {
                throw (new ModelNotFoundException)->setModel(config('fintech.tab.pay_bill_model'), $id);
            }

            $inputs = $request->validated();

            if (!tab()->payBill()->update($id, $inputs)) {

                throw (new UpdateOperationException)->setModel(config('fintech.tab.pay_bill_model'), $id);
            }

            return response()->updated(__('core::messages.resource.updated', ['model' => 'Pay Bill']));

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Return a specified *PayBill* resource found by id.
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     */
    public function show(string|int $id): PayBillResource|JsonResponse
    {
        try {

            $payBill = tab()->payBill()->find($id);

            if (! $payBill) {
                throw (new ModelNotFoundException)->setModel(config('fintech.tab.pay_bill_model'), $id);
            }

            return new PayBillResource($payBill);

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified *PayBill* resource using id.
     *
     * @lrd:end
     */
    public function destroy(string|int $id): JsonResponse
    {
        try {

            $payBill = tab()->payBill()->find($id);

            if (! $payBill) {
                throw (new ModelNotFoundException)->setModel(config('fintech.tab.pay_bill_model'), $id);
            }

            if (!tab()->payBill()->destroy($id)) {

                throw (new DeleteOperationException)->setModel(config('fintech.tab.pay_bill_model'), $id);
            }

            return response()->deleted(__('core::messages.resource.deleted', ['model' => 'Pay Bill']));

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Restore the specified *PayBill* resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     *
     * @lrd:end
     */
    public function restore(string|int $id): JsonResponse
    {
        try {

            $payBill = tab()->payBill()->find($id, true);

            if (! $payBill) {
                throw (new ModelNotFoundException)->setModel(config('fintech.tab.pay_bill_model'), $id);
            }

            if (!tab()->payBill()->restore($id)) {

                throw (new RestoreOperationException)->setModel(config('fintech.tab.pay_bill_model'), $id);
            }

            return response()->restored(__('core::messages.resource.restored', ['model' => 'Pay Bill']));

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Create an exportable list of the *PayBill* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     */
    public function export(IndexPayBillRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            // $payBillPaginate =tab()->payBill()->export($inputs);
            tab()->payBill()->export($inputs);

            return response()->exported(__('core::messages.resource.exported', ['model' => 'Pay Bill']));

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Create an exportable list of the *PayBill* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     */
    public function import(ImportPayBillRequest $request): PayBillCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $payBillPaginate = tab()->payBill()->list($inputs);

            return new PayBillCollection($payBillPaginate);

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }
}
