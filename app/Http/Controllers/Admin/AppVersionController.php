<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\KaraVersionRepositoryInterface;
use App\Http\Requests\Admin\KaraVersionRequest;
use App\Http\Requests\PaginationRequest;
use App\Services\FileUploadServiceInterface;
use App\Repositories\ApplicationRepositoryInterface;

class AppVersionController extends Controller
{

    /** @var \App\Repositories\KaraVersionRepositoryInterface */
    protected $karaVersionRepository;

    /** @var FileUploadServiceInterface $fileUploadService */
    protected $fileUploadService;

    /** @var \App\Repositories\ApplicationRepositoryInterface */
    protected $applicationRepository;

    public function __construct(
        KaraVersionRepositoryInterface  $karaVersionRepository,
        FileUploadServiceInterface      $fileUploadService,
        ApplicationRepositoryInterface  $applicationRepository
    )
    {
        $this->karaVersionRepository    = $karaVersionRepository;
        $this->fileUploadService        = $fileUploadService;
        $this->applicationRepository    = $applicationRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     * @return \Response
     */
    public function index(PaginationRequest $request)
    {
        $paginate['offset']     = $request->offset();
        $paginate['limit']      = $request->limit();
        $paginate['order']      = $request->order();
        $paginate['direction']  = $request->direction();
        $paginate['baseUrl']    = action( 'Admin\AppVersionController@index' );

        $count = $this->karaVersionRepository->count();
        $karaVersions = $this->karaVersionRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.app-versions.index',
            [
                'karaVersions' => $karaVersions,
                'count'        => $count,
                'paginate'     => $paginate,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view(
            'pages.admin.' . config('view.admin') . '.app-versions.edit',
            [
                'isNew'        => true,
                'karaVersion'  => $this->karaVersionRepository->getBlankModel(),
                'applications' => $this->applicationRepository->all()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(KaraVersionRequest $request)
    {
        $input = $request->only(['version','name','description']);
        $input['application_id'] = $request->get('application_id', 0);

        $karaVersion = $this->karaVersionRepository->create($input);

        if (empty( $karaVersion )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        if ($request->hasFile('apk_package')) {
            $file = $request->file('apk_package');

            $apk = $this->fileUploadService->upload(
                'kara_apk',
                $file,
                [
                    'entity_type' => 'kara_apk',
                    'entity_id'   => $karaVersion->id,
                    'title'       => $request->input('version', ''),
                ]
            );

            if (!empty($apk)) {
                $this->karaVersionRepository->update($karaVersion, ['apk_package_id' => $apk->id]);
            }
        }

        return redirect()->action('Admin\AppVersionController@index')
            ->with('message-success', trans('admin.messages.general.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Response
     */
    public function show($id)
    {
        $karaVersion = $this->karaVersionRepository->find($id);
        if (empty( $karaVersion )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.app-versions.edit',
            [
                'isNew'        => false,
                'karaVersion'  => $karaVersion,
                'applications' => $this->applicationRepository->all()
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param      $request
     * @return \Response
     */
    public function update($id, KaraVersionRequest $request)
    {
        /** @var \App\Models\KaraVersion $karaVersion */
        $karaVersion = $this->karaVersionRepository->find($id);
        if (empty( $karaVersion )) {
            abort(404);
        }
        $input = $request->only(['version','name','description']);
        $input['application_id'] = $request->get('application_id', 0);

        $this->karaVersionRepository->update($karaVersion, $input);

        if ($request->hasFile('apk_package')) {
            $currentApk = $karaVersion->apkPackage;
            $file = $request->file('apk_package');

            $newApk = $this->fileUploadService->upload(
                'kara_apk',
                $file,
                [
                    'entity_type' => 'kara_apk',
                    'entity_id'   => $karaVersion->id,
                    'title'       => $request->input('version', ''),
                ]
            );

            if (!empty($newApk)) {
                $this->karaVersionRepository->update($karaVersion, ['apk_package_id' => $newApk->id]);

                if (!empty($currentApk)) {
                    $this->fileUploadService->delete($currentApk);
                }
            }
        }

        return redirect()->action('Admin\AppVersionController@show', [$id])
                    ->with('message-success', trans('admin.messages.general.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Response
     */
    public function destroy($id)
    {
        /** @var \App\Models\KaraVersion $karaVersion */
        $karaVersion = $this->karaVersionRepository->find($id);
        if (empty( $karaVersion )) {
            abort(404);
        }
        $this->karaVersionRepository->delete($karaVersion);

        return redirect()->action('Admin\AppVersionController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
