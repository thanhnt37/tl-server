<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\CategoryRepositoryInterface;

class CategoryRequest extends BaseRequest
{

    /** @var \App\Repositories\CategoryRepositoryInterface */
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
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
        return $this->categoryRepository->rules();
    }

    public function messages()
    {
        return $this->categoryRepository->messages();
    }

}
