<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\ApplicationRepositoryInterface;

class ApplicationRequest extends BaseRequest
{

    /** @var \App\Repositories\ApplicationRepositoryInterface */
    protected $applicationRepository;

    public function __construct(ApplicationRepositoryInterface $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
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
        return $this->applicationRepository->rules();
    }

    public function messages()
    {
        return $this->applicationRepository->messages();
    }

}
