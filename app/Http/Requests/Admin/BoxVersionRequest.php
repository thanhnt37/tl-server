<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\BoxVersionRepositoryInterface;

class BoxVersionRequest extends BaseRequest
{

    /** @var \App\Repositories\BoxVersionRepositoryInterface */
    protected $boxVersionRepository;

    public function __construct(BoxVersionRepositoryInterface $boxVersionRepository)
    {
        $this->boxVersionRepository = $boxVersionRepository;
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
        return $this->boxVersionRepository->rules();
    }

    public function messages()
    {
        return $this->boxVersionRepository->messages();
    }

}
