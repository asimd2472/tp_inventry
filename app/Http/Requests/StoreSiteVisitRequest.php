<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteVisitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // or: return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'visit_date'          => ['required', 'date'],
            'visit_time'          => ['required', 'date_format:H:i'],

            'customer_name'       => ['required', 'string', 'max:150'],
            'mobile'              => ['required', 'regex:/^[6-9][0-9]{9}$/'],
            'alt_mobile'          => ['nullable', 'digits:10'],
            'customer_email'      => ['nullable', 'email', 'max:255'],

            'state'               => ['required', 'string', 'max:100'],
            'district'            => ['required', 'string', 'max:100'],
            'pincode'             => ['nullable', 'digits:6'],
            'gps'                 => ['nullable', 'regex:/^-?\d{1,3}\.\d+,\s*-?\d{1,3}\.\d+$/'],
            'maps_link'           => ['nullable', 'url', 'max:255'],

            'construction_stage'  => ['required', 'string', 'max:120'],

            'products'            => ['required', 'array', 'min:1'],
            'products.*'          => ['string', 'max:80'],
            'categories'          => ['nullable', 'array'],
            'categories.*'        => ['string', 'max:120'],

            'qty'                 => ['nullable', 'array'],
            'qty.doors'           => ['nullable', 'integer', 'min:0', 'max:9999'],
            'qty.windows'         => ['nullable', 'integer', 'min:0', 'max:9999'],
            'qty.frames'          => ['nullable', 'integer', 'min:0', 'max:9999'],
            'qty.others'          => ['nullable', 'integer', 'min:0', 'max:9999'],

            'timeline'            => ['required', 'string', 'max:60'],
            'budget'              => ['nullable', 'string', 'max:60'],
            'competitor'          => ['nullable', 'string', 'max:60'],

            'interest'            => ['required', 'in:Low,Medium,High'],
            'follow_up'           => ['nullable', 'in:Yes,1,on'],
            'remarks'             => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'mobile.regex'    => 'Enter a valid 10-digit Indian mobile number.',
            'products.min'    => 'Select at least one product requirement.',
        ];
    }
}
