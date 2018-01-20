<?php namespace App\Http\Requests\Admin;

use App\Http\Requests\BaseRequest;
use App\Repositories\KaraVersionRepositoryInterface;

class KaraVersionRequest extends BaseRequest
{

    /** @var \App\Repositories\KaraVersionRepositoryInterface */
    protected $karaVersionRepository;

    public function __construct(KaraVersionRepositoryInterface $karaVersionRepository)
    {
        $this->karaVersionRepository = $karaVersionRepository;
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
        $id = ($this->method() == 'PUT') ? $this->route('app_version') : 0;

        $rules = [
            'version' => 'required|string|unique:kara_versions,version,' . $id,
            'name'    => 'required|string'
        ];

        return $rules;
    }

    public function messages()
    {
        return $this->karaVersionRepository->messages();
    }

}
