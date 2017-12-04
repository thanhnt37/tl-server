<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\BoxRepositoryInterface;

class BoxRequest extends BaseRequest
{

    /** @var \App\Repositories\BoxRepositoryInterface */
    protected $boxRepository;

    public function __construct(BoxRepositoryInterface $boxRepository)
    {
        $this->boxRepository = $boxRepository;
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
        return $this->boxRepository->rules();
    }

    public function messages()
    {
        return $this->boxRepository->messages();
    }

}
