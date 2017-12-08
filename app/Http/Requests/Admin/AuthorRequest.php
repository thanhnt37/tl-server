<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\AuthorRepositoryInterface;

class AuthorRequest extends BaseRequest
{

    /** @var \App\Repositories\AuthorRepositoryInterface */
    protected $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository)
    {
        $this->authorRepository = $authorRepository;
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
        return $this->authorRepository->rules();
    }

    public function messages()
    {
        return $this->authorRepository->messages();
    }

}
