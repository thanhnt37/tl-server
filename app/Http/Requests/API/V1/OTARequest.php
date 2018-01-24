<?php
namespace App\Http\Requests\API\V1;

class OTARequest extends Request
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
        $rules = [
            'imei'           => 'required|string',
            'sdk_version_id' => 'required|numeric|min:0',
            'apk_version_id' => 'required|numeric|min:0',
            'app_key'        => 'required|string'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
        ];
    }
}
