<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\CustomerRepositoryInterface;

class CustomerRequest extends BaseRequest
{

    /** @var \App\Repositories\CustomerRepositoryInterface */
    protected $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
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
        return $this->customerRepository->rules();
    }

    public function messages()
    {
        return $this->customerRepository->messages();
    }

}
