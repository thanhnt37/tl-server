<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\SaleRepositoryInterface;

class SaleRequest extends BaseRequest
{

    /** @var \App\Repositories\SaleRepositoryInterface */
    protected $saleRepository;

    public function __construct(SaleRepositoryInterface $saleRepository)
    {
        $this->saleRepository = $saleRepository;
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
        return $this->saleRepository->rules();
    }

    public function messages()
    {
        return $this->saleRepository->messages();
    }

}
