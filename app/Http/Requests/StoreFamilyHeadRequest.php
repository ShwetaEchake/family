<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class StoreFamilyHeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'max:100'],
            'surname'        => ['required', 'string', 'max:100'],
            'birthdate'      => ['required', 'date', 'before_or_equal:' . now()->subYears(21)->toDateString()],
            'mobile_no'      => ['required', 'string', 'regex:/^[6-9]\d{9}$/'],
            'address'        => ['required', 'string', 'max:500'],
            'state'          => ['required', 'string', 'max:100'],
            'city'           => ['required', 'string', 'max:100'],
            'pincode'        => ['required', 'string', 'regex:/^\d{6}$/'],
            'marital_status' => ['required', 'in:married,unmarried'],
            'wedding_date'   => ['nullable', 'date', 'required_if:marital_status,married', 'before_or_equal:today'],
            'photo'          => ['required', 'image', 'mimes:jpeg,png,jpg,webp'],

            'hobbies'        => ['required', 'array'],
            'hobbies.*'      => ['required', 'string', 'max:100'],

            'member_name'               => ['required', 'array'],
            'member_name.*'             => ['required', 'string', 'max:100'],
            'member_birthdate'          => ['required', 'array'],
            'member_birthdate.*'        => ['required', 'date'],

            'member_marital_status'     => ['required', 'array'],
            'member_marital_status.*'   => ['required', 'in:married,unmarried'],

            'member_wedding_date'       => ['nullable', 'array'],
            'member_wedding_date.*'     => ['nullable', 'date'],

            'education'                 => ['required', 'array'],
            'education.*'               => ['required', 'string', 'max:200'],
            'document'                  => ['required', 'array'],
            'document.*'                => ['required', 'image', 'mimes:jpeg,png,jpg,webp'],

        ];
    }


    public function messages(): array
    {
        return [
            'name.required'                     => 'Family head name is required.',
            'surname.required'                  => 'Surname is required.',
            'birthdate.required'                => 'Birthdate is required.',
            'birthdate.before_or_equal'         => 'Family head must be at least 21 years old.',
            'mobile_no.required'                => 'Mobile number is required.',
            'mobile_no.regex'                   => 'Please enter a valid 10-digit Indian mobile number.',
            'address.required'                  => 'Address is required.',
            'state.required'                    => 'Please select a state.',
            'city.required'                     => 'Please select a city.',
            'pincode.required'                  => 'Pincode is required.',
            'pincode.regex'                     => 'Pincode must be a valid 6-digit number.',
            'marital_status.required'           => 'Marital status is required.',
            'wedding_date.required_if'          => 'Wedding date is required when married.',

            'hobbies.required'     => 'Please add at least one hobby.',
            'hobbies.*.required'   => 'Please enter hobby.',
            'hobbies.*.max'        => 'Hobby must not exceed 100 characters.',


            'member_name.*.required' => 'Member name is required.',
            'member_birthdate.*.required' => 'Member birthdate is required.',
            'member_marital_status.*.required' => 'Member marital status is required.',
            // 'member_wedding_date.*.required' => 'Wedding date is required for married members.',
            'education.*.required' => 'Education is required.',
            'document.*.required' => 'Member photo is required.',


        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $birthdates = $this->member_birthdate ?? [];
            $weddings   = $this->member_wedding_date ?? [];
            $statuses   = $this->member_marital_status ?? [];

            foreach ($statuses as $key => $status) {

                if ($status === 'married') {

                    if (!empty($birthdates[$key]) && !empty($weddings[$key])) {

                        if (strtotime($weddings[$key]) < strtotime($birthdates[$key])) {
                            $validator->errors()->add(
                                "member_wedding_date.$key",
                                "Wedding date cannot be before birthdate"
                            );
                        }
                    }
                }
            }

        });
    }


}
