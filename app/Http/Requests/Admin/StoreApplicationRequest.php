<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\StoreApplicationRepositoryInterface;

class StoreApplicationRequest extends BaseRequest
{

    /** @var \App\Repositories\StoreApplicationRepositoryInterface */
    protected $storeApplicationRepository;

    public function __construct(StoreApplicationRepositoryInterface $storeApplicationRepository)
    {
        $this->storeApplicationRepository = $storeApplicationRepository;
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
        return $this->storeApplicationRepository->rules();
    }

    public function messages()
    {
        return $this->storeApplicationRepository->messages();
    }

}
