<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\DeveloperRepositoryInterface;

class DeveloperRequest extends BaseRequest
{

    /** @var \App\Repositories\DeveloperRepositoryInterface */
    protected $developerRepository;

    public function __construct(DeveloperRepositoryInterface $developerRepository)
    {
        $this->developerRepository = $developerRepository;
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
        return $this->developerRepository->rules();
    }

    public function messages()
    {
        return $this->developerRepository->messages();
    }

}
