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
            'sdk_version_id' => 'required|numeric',
            'apk_version_id' => 'required|numeric'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
        ];
    }
}
