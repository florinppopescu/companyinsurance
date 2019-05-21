<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormValidator extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // we authorize the request publicly
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // please see that the CompaniesHouses API does not provide length or
        // other parameter details for the company number and the name format
        // we are using fields for first_name and last_name, in order to perform
        // a better search futher in the Company Officers api, as the format
        // of officer name is:
        //  - UPPER CAPS last name,
        //  - first letter upper case for the last name
        return [
            'company_number' => 'required|string|min:1|max:32',
            'first_name' => 'required|string|min:2|max:256',
            'last_name' => 'required|string|min:2|max:256',
        ];
    }

    /**
     * Get custom names for the attributes
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'company_number' => 'Company number',
            'first_name' => 'First name',
            'last_name' => 'Last name',
        ];
    }
}
