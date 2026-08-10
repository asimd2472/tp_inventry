<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'visit_time'          => ['required', 'date_format:H:i,H:i:s'],

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

    protected function prepareForValidation(): void
    {
        $nullableFields = [
            'alt_mobile',
            'customer_email',
            'pincode',
            'gps',
            'maps_link',
            'budget',
            'competitor',
            'remarks',
        ];

        $normalized = [];
        foreach ($nullableFields as $field) {
            $value = $this->input($field);
            if ($value === '' || $value === null) {
                $normalized[$field] = null;
            }
        }

        if ($this->filled('visit_time')) {
            $normalized['visit_time'] = substr((string) $this->input('visit_time'), 0, 5);
        }

        if (! empty($normalized)) {
            $this->merge($normalized);
        }
    }

    protected function failedValidation(Validator $validator): void
    {
        if ($this->expectsJson() || $this->ajax()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Please fix the highlighted fields and try again.',
                'errors' => $validator->errors(),
            ], 422));
        }

        parent::failedValidation($validator);
    }

    public function messages(): array
    {
        return [
            'mobile.regex'    => 'Enter a valid 10-digit Indian mobile number.',
            'products.min'    => 'Select at least one product requirement.',
        ];
    }
}
