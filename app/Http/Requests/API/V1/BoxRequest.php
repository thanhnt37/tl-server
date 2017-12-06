<?php
namespace App\Http\Requests\API\V1;

class BoxRequest extends Request
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
        $id = ($this->method() == 'PUT') ? $this->route('boxes') : 0;

        $rules = [
            'imei'   => 'required|string'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
        ];
    }
}
