<?php
namespace App\Http\Controllers\Admin;

use ApkParser\Parser;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\StoreApplicationRepositoryInterface;
use App\Http\Requests\Admin\StoreApplicationRequest;
use App\Http\Requests\PaginationRequest;
use App\Services\FileUploadServiceInterface;
use App\Services\ImageServiceInterface;
use App\Repositories\ImageRepositoryInterface;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\DeveloperRepositoryInterface;

class StoreApplicationController extends Controller
{
    /** @var \App\Repositories\StoreApplicationRepositoryInterface */
    protected $storeApplicationRepository;

    /** @var \App\Services\FileUploadServiceInterface */
    protected $fileUploadService;

    /** @var  \App\Services\ImageServiceInterface */
    protected $imageService;

    /** @var  \App\Repositories\ImageRepositoryInterface */
    protected $imageRepository;

    /** @var  \App\Repositories\CategoryRepositoryInterface */
    protected $categoryRepository;

    /** @var  \App\Repositories\DeveloperRepositoryInterface */
    protected $developerRepository;

    public function __construct(
        StoreApplicationRepositoryInterface $storeApplicationRepository,
        FileUploadServiceInterface          $fileUploadService,
        ImageServiceInterface               $imageService,
        ImageRepositoryInterface            $imageRepository,
        CategoryRepositoryInterface         $categoryRepository,
        DeveloperRepositoryInterface        $developerRepository
    ) {
        $this->storeApplicationRepository   = $storeApplicationRepository;
        $this->fileUploadService            = $fileUploadService;
        $this->imageService                 = $imageService;
        $this->imageRepository              = $imageRepository;
        $this->categoryRepository           = $categoryRepository;
        $this->developerRepository          = $developerRepository;
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
        $paginate['direction']  = $request->direction('asc');
        $paginate['baseUrl']    = action( 'Admin\StoreApplicationController@index' );

        $count = $this->storeApplicationRepository->count();
        $storeApplications = $this->storeApplicationRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.store-applications.index',
            [
                'storeApplications' => $storeApplications,
                'count'             => $count,
                'paginate'          => $paginate,
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
            'pages.admin.' . config('view.admin') . '.store-applications.edit',
            [
                'isNew'            => true,
                'storeApplication' => $this->storeApplicationRepository->getBlankModel(),
                'categories'       => $this->categoryRepository->all(),
                'developers'       => $this->developerRepository->all()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(StoreApplicationRequest $request)
    {
        $input = $request->only(
            [
                'name', 'version_name', 'version_code',
                'package_name', 'description', 'hit',
                'publish_started_at', 'category_id', 'developer_id'
            ]
        );

        $storeApplication = $this->storeApplicationRepository->create($input);

        if (empty( $storeApplication )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');

            $newImage = $this->fileUploadService->upload(
                'store-app_background_image',
                $file,
                [
                    'entity_type' => 'store-app_background_image',
                    'entity_id'   => $storeApplication->id,
                    'title'       => $storeApplication->name,
                ]
            );

            if (!empty($newImage)) {
                $this->storeApplicationRepository->update($storeApplication, ['background_image_id' => $newImage->id]);
            }
        } else {
            $imageUrl = $request->get('background_image_url', '');
            if( $imageUrl != '' ) {
                $newImage = $this->imageRepository->create(
                    [
                        'url'      => $imageUrl,
                        'is_local' => false
                    ]
                );

                if (!empty($newImage)) {
                    $this->storeApplicationRepository->update($storeApplication, ['background_image_id' => $newImage->id]);
                }
            }
        }

        if ($request->hasFile('icon_image')) {
            $file = $request->file('icon_image');

            $newImage = $this->fileUploadService->upload(
                'store-app_icon_image',
                $file,
                [
                    'entity_type' => 'store-app_icon_image',
                    'entity_id'   => $storeApplication->id,
                    'title'       => $storeApplication->name,
                ]
            );

            if (!empty($newImage)) {
                $this->storeApplicationRepository->update($storeApplication, ['icon_image_id' => $newImage->id]);
            }
        } else {
            $imageUrl = $request->get('icon_image_url', '');
            if( $imageUrl != '' ) {
                $newImage = $this->imageRepository->create(
                    [
                        'url'      => $imageUrl,
                        'is_local' => false
                    ]
                );

                if (!empty($newImage)) {
                    $this->storeApplicationRepository->update($storeApplication, ['icon_image_id' => $newImage->id]);
                }
            }
        }

        if ($request->hasFile('apk_package')) {
            $file = $request->file('apk_package');

            $apk = new Parser($file->path());
            $manifest = $apk->getManifest();

            $params = [];
            if( $manifest->getVersionName() != '' ) {
                $params['version_name'] = $manifest->getVersionName();
            }
            if( $manifest->getVersionCode() != '' ) {
                $params['version_code'] = $manifest->getVersionCode();
            }
            if( $manifest->getPackageName() != '' ) {
                $params['package_name'] = $manifest->getPackageName();
            }
            if( $manifest->getMinSdkLevel() != '' ) {
                $params['min_sdk'] = $manifest->getMinSdkLevel();
            }

            $newAPK = $this->fileUploadService->upload(
                'store-app_apk',
                $file,
                [
                    'entity_type' => 'store-app_apk',
                    'entity_id'   => $storeApplication->id,
                    'title'       => $storeApplication->name,
                ]
            );

            if (!empty($apk)) {
                $params['apk_package_id'] = $newAPK->id;

                $this->storeApplicationRepository->update($storeApplication, $params);
            }
        }

        return redirect()->action('Admin\StoreApplicationController@index')
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
        $storeApplication = $this->storeApplicationRepository->find($id);
        if (empty( $storeApplication )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.store-applications.edit',
            [
                'isNew'            => false,
                'storeApplication' => $storeApplication,
                'categories'       => $this->categoryRepository->all(),
                'developers'       => $this->developerRepository->all()
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
    public function update($id, StoreApplicationRequest $request)
    {
        /** @var \App\Models\StoreApplication $storeApplication */
        $storeApplication = $this->storeApplicationRepository->find($id);
        if (empty( $storeApplication )) {
            abort(404);
        }

        $input = $request->only(
            [
                'name', 'version_name', 'version_code',
                'package_name', 'description', 'hit',
                'publish_started_at', 'category_id', 'developer_id'
            ]
        );

        if ($request->hasFile('background_image')) {
            $currentImage = $storeApplication->backgroundImage;
            $file = $request->file('background_image');

            $newImage = $this->fileUploadService->upload(
                'store-app_background_image',
                $file,
                [
                    'entity_type' => 'store-app_background_image',
                    'entity_id'   => $storeApplication->id,
                    'title'       => $storeApplication->name,
                ]
            );

            if (!empty($newImage)) {
                $input['background_image_id'] = $newImage->id;

                if (!empty($currentImage)) {
                    $this->fileUploadService->delete($currentImage);
                }
            }
        } else {
            $imageUrl = $request->get('background_image_url', '');
            if( $imageUrl != '' ) {
                $currentImage = $storeApplication->backgroundImage;
                if( !empty($currentImage) ) {
                    $this->imageRepository->update(
                        $currentImage,
                        [
                            'url'      => $imageUrl,
                            'is_local' => false
                        ]
                    );
                } else {
                    $image = $this->imageRepository->create(
                        [
                            'url'      => $imageUrl,
                            'is_local' => false
                        ]
                    );
                    $input['background_image_id'] = $image->id;
                }
            }
        }

        if ($request->hasFile('icon_image')) {
            $currentImage = $storeApplication->iconImage;
            $file = $request->file('icon_image');

            $newImage = $this->fileUploadService->upload(
                'store-app_icon_image',
                $file,
                [
                    'entity_type' => 'store-app_icon_image',
                    'entity_id'   => $storeApplication->id,
                    'title'       => $storeApplication->name,
                ]
            );

            if (!empty($newImage)) {
                $input['icon_image_id'] = $newImage->id;

                if (!empty($currentImage)) {
                    $this->fileUploadService->delete($currentImage);
                }
            }
        } else {
            $imageUrl = $request->get('icon_image_url', '');
            if( $imageUrl != '' ) {
                $currentImage = $storeApplication->iconImage;
                if( !empty($currentImage) ) {
                    $this->imageRepository->update(
                        $currentImage,
                        [
                            'url'      => $imageUrl,
                            'is_local' => false
                        ]
                    );
                } else {
                    $image = $this->imageRepository->create(
                        [
                            'url'      => $imageUrl,
                            'is_local' => false
                        ]
                    );
                    $input['icon_image_id'] = $image->id;
                }
            }
        }

        if ($request->hasFile('apk_package')) {
            $currentApk = $storeApplication->apkPackage;
            $file = $request->file('apk_package');

            $apk = new Parser($file->path());
            $manifest = $apk->getManifest();

            if( $manifest->getVersionName() != '' ) {
                $input['version_name'] = $manifest->getVersionName();
            }
            if( $manifest->getVersionCode() != '' ) {
                $input['version_code'] = $manifest->getVersionCode();
            }
            if( $manifest->getPackageName() != '' ) {
                $input['package_name'] = $manifest->getPackageName();
            }
            if( $manifest->getMinSdkLevel() != '' ) {
                $input['min_sdk'] = $manifest->getMinSdkLevel();
            }

            $newApk = $this->fileUploadService->upload(
                'store-app_apk',
                $file,
                [
                    'entity_type' => 'store-app_apk',
                    'entity_id'   => $storeApplication->id,
                    'title'       => $storeApplication->name,
                ]
            );

            if (!empty($newApk)) {
                $input['apk_package_id'] = $newApk->id;

                if (!empty($currentApk)) {
                    $this->fileUploadService->delete($currentApk);
                }
            }
        }

        $this->storeApplicationRepository->update($storeApplication, $input);

        return redirect()->action('Admin\StoreApplicationController@show', [$id])
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
        /** @var \App\Models\StoreApplication $storeApplication */
        $storeApplication = $this->storeApplicationRepository->find($id);
        if (empty( $storeApplication )) {
            abort(404);
        }
        $this->storeApplicationRepository->delete($storeApplication);

        return redirect()->action('Admin\StoreApplicationController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
