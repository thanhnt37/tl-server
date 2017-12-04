<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\KaraOtaRepositoryInterface;

class KaraOtaRequest extends BaseRequest
{

    /** @var \App\Repositories\KaraOtaRepositoryInterface */
    protected $karaOtaRepository;

    public function __construct(KaraOtaRepositoryInterface $karaOtaRepository)
    {
        $this->karaOtaRepository = $karaOtaRepository;
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
        return $this->karaOtaRepository->rules();
    }

    public function messages()
    {
        return $this->karaOtaRepository->messages();
    }

}
