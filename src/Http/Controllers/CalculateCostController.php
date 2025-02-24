<?php

namespace Fintech\Tab\Http\Controllers;

use Exception;
use Fintech\Auth\Facades\Auth;
use Fintech\Business\Facades\Business;
use Fintech\Business\Http\Resources\ServiceCostResource;
use Fintech\Core\Abstracts\BaseModel;
use Fintech\Core\Enums\Transaction\OrderStatus;
use Fintech\Tab\Exceptions\TabException;
use Fintech\Tab\Facades\Tab;
use Fintech\Tab\Http\Requests\PayBillRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;

class CalculateCostController extends Controller
{
    /**
     * @lrd:start
     */
    public function __invoke(PayBillRequest $request): ServiceCostResource|JsonResponse
    {
        $inputs = $request->validated();

        try {

            if ($request->missing('user_id')) {
                $inputs['user_id'] = $request->user('sanctum')->id;
            }

            if ($user = Auth::user()->find($inputs['user_id'])) {
                $inputs['role_id'] = $user->roles->first()?->getKey() ?? null;
            }

            $service = Business::service()->find($inputs['service_id']);

            $vendor = Business::serviceVendor()->find($service->service_vendor_id);

            $inputs['service_vendor_id'] = $vendor?->getKey() ?? null;

            $quote = new BaseModel;

            $quote->source_country_id = $inputs['source_country_id'];
            $quote->destination_country_id = $inputs['destination_country_id'];
            $quote->service_vendor_id = $vendor->getKey();
            $quote->service_id = $inputs['service_id'];
            $quote->user_id = $inputs['user_id'];
            $quote->vendor = $inputs['vendor'] ?? $vendor->service_vendor_slug;
            $quote->status = OrderStatus::Pending->value;
            $quote->order_data = [
                'pay_bill_data' => $inputs['pay_bill_data'],
                'service_stat_data' => $inputs,
            ];
            $quote->order_number = 'CANPB'.Str::padLeft(time(), 15, '0');
            $quote->is_refunded = 'no';

            $quoteInfo = Tab::assignVendor()->requestQuote($quote);

            if ($quoteInfo['status'] === false) {
                throw new TabException(__('core::messages.assign_vendor.quote_failed'));
            }

            $inputs['amount'] = $quoteInfo['amount'];

            $exchangeRate = Business::serviceStat()->cost($inputs);

            $exchangeRate['vendor_info'] = $quoteInfo;

            return new ServiceCostResource($exchangeRate);

        }  catch (Exception $exception) {

            return response()->failed($exception);
        }

    }
}
