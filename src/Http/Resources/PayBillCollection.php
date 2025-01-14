<?php

namespace Fintech\Tab\Http\Resources;

use Fintech\Core\Facades\Core;
use Fintech\Core\Supports\Constant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PayBillCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->map(function ($pay_bill) {
            $data = [
                'id' => $payBill->getKey(),
                'source_country_id' => $payBill->source_country_id ?? null,
                'source_country_name' => null,
                'destination_country_id' => $payBill->destination_country_id ?? null,
                'destination_country_name' => null,
                'parent_id' => $payBill->parent_id ?? null,
                'sender_receiver_id' => $payBill->sender_receiver_id ?? null,
                'sender_receiver_name' => null,
                'user_id' => $payBill->user_id ?? null,
                'user_name' => null,
                'service_id' => $payBill->service_id ?? null,
                'service_name' => null,
                'service_type' => null,
                'transaction_form_id' => $payBill->transaction_form_id ?? null,
                'transaction_form_name' => $payBill->transaction_form_name ?? null,
                'ordered_at' => $payBill->ordered_at ?? null,
                'amount' => $payBill->amount ?? null,
                'currency' => $payBill->currency ?? null,
                'converted_amount' => $payBill->converted_amount ?? null,
                'converted_currency' => $payBill->converted_currency ?? null,
                'order_number' => $payBill->order_number ?? null,
                'risk' => $payBill->risk ?? null,
                'notes' => $payBill->notes ?? null,
                'is_refunded' => $payBill->is_refunded ?? null,
                'order_data' => $payBill->order_data ?? null,
                'status' => $payBill->status ?? null,
            ] + $payBill->commonAttributes();

            if (Core::packageExists('MetaData')) {
                $data['source_country_name'] = $payBill->sourceCountry?->name ?? null;
                $data['destination_country_name'] = $payBill->destinationCountry?->name ?? null;
            }

            if (Core::packageExists('Auth')) {
                $data['sender_receiver_name'] = $payBill->senderReceiver?->name ?? null;
                $data['user_name'] = $payBill->user?->name ?? null;
            }

            if (Core::packageExists('Business')) {
                $data['service_name'] = $payBill->service?->service_name ?? null;
                $data['service_type'] = $payBill->service->serviceType?->all_parent_list ?? null;
            }

            return $data;
        })->toArray();
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'options' => [
                'dir' => Constant::SORT_DIRECTIONS,
                'per_page' => Constant::PAGINATE_LENGTHS,
                'sort' => ['id', 'name', 'created_at', 'updated_at'],
            ],
            'query' => $request->all(),
        ];
    }
}
