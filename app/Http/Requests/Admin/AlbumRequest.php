<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\AlbumRepositoryInterface;

class AlbumRequest extends BaseRequest
{

    /** @var \App\Repositories\AlbumRepositoryInterface */
    protected $albumRepository;

    public function __construct(AlbumRepositoryInterface $albumRepository)
    {
        $this->albumRepository = $albumRepository;
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
        return $this->albumRepository->rules();
    }

    public function messages()
    {
        return $this->albumRepository->messages();
    }

}
