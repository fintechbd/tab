<?php

namespace Fintech\Tab\Http\Requests;

use Fintech\Business\Facades\Business;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePayBillRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => ['nullable', 'integer', 'min:1'],
            'source_country_id' => ['required', 'integer', 'min:1'],
            'destination_country_id' => ['required', 'integer', 'min:1'],
            'service_id' => ['required', 'integer', 'min:1'],
            'ordered_at' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:'.date('Y-m-d')],
            'amount' => ['required', 'numeric'],
            'currency' => ['required', 'string', 'size:3'],
            'converted_currency' => ['required', 'string', 'size:3'],
            'order_data' => ['nullable', 'array'],
            'order_data.request_from' => ['string', 'required'],
            'order_data.role_id' => ['integer', 'nullable', 'min:1'],
        ];

        Business::serviceField()->list([
            'paginate' => false,
            'service_id' => $this->service_id,
        ])->each(function ($serviceField) use (&$rules) {
            $validation = $serviceField->validation ?? 'string|nullable';
            $rules["order_data.{$serviceField->name}"] = explode('|', $validation);
        });
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
