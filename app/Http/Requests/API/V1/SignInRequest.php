<?php
namespace App\Http\Requests\API\V1;

class SignInRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'imei'          => 'required|string',
            'grant_type'    => 'required',
            'client_id'     => 'required',
            'client_secret' => 'required',

        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
