<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\OsVersionRepositoryInterface;

class OsVersionRequest extends BaseRequest
{

    /** @var \App\Repositories\OsVersionRepositoryInterface */
    protected $osVersionRepository;

    public function __construct(OsVersionRepositoryInterface $osVersionRepository)
    {
        $this->osVersionRepository = $osVersionRepository;
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
        return $this->osVersionRepository->rules();
    }

    public function messages()
    {
        return $this->osVersionRepository->messages();
    }

}
