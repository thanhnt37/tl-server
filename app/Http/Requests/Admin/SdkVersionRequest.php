<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\SdkVersionRepositoryInterface;

class SdkVersionRequest extends BaseRequest
{

    /** @var \App\Repositories\SdkVersionRepositoryInterface */
    protected $sdkVersionRepository;

    public function __construct(SdkVersionRepositoryInterface $sdkVersionRepository)
    {
        $this->sdkVersionRepository = $sdkVersionRepository;
    }

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
        return $this->sdkVersionRepository->rules();
    }

    public function messages()
    {
        return $this->sdkVersionRepository->messages();
    }

}
