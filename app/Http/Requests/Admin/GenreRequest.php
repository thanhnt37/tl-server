<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\GenreRepositoryInterface;

class GenreRequest extends BaseRequest
{

    /** @var \App\Repositories\GenreRepositoryInterface */
    protected $genreRepository;

    public function __construct(GenreRepositoryInterface $genreRepository)
    {
        $this->genreRepository = $genreRepository;
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
        return $this->genreRepository->rules();
    }

    public function messages()
    {
        return $this->genreRepository->messages();
    }

}
