<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\SingerRepositoryInterface;

class SingerRequest extends BaseRequest
{

    /** @var \App\Repositories\SingerRepositoryInterface */
    protected $singerRepository;

    public function __construct(SingerRepositoryInterface $singerRepository)
    {
        $this->singerRepository = $singerRepository;
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
        return $this->singerRepository->rules();
    }

    public function messages()
    {
        return $this->singerRepository->messages();
    }

}
