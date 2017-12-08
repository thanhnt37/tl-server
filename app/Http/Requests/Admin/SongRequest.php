<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\SongRepositoryInterface;

class SongRequest extends BaseRequest
{

    /** @var \App\Repositories\SongRepositoryInterface */
    protected $songRepository;

    public function __construct(SongRepositoryInterface $songRepository)
    {
        $this->songRepository = $songRepository;
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
        return $this->songRepository->rules();
    }

    public function messages()
    {
        return $this->songRepository->messages();
    }

}
