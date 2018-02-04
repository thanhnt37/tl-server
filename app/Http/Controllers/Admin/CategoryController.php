<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\CategoryRepositoryInterface;
use App\Services\FileUploadServiceInterface;
use App\Http\Requests\Admin\CategoryRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\ImageRepositoryInterface;
use App\Repositories\StoreApplicationRepositoryInterface;

class CategoryController extends Controller
{

    /** @var \App\Repositories\CategoryRepositoryInterface */
    protected $categoryRepository;
    protected $fileUploadService;
    protected $imageRepository;
    protected $storeApplicationRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        FileUploadServiceInterface $fileUploadService,
        ImageRepositoryInterface $imageRepository,
        StoreApplicationRepositoryInterface $storeApplicationRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->fileUploadService = $fileUploadService;
        $this->imageRepository = $imageRepository;
        $this->storeApplicationRepository = $storeApplicationRepository;
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
        $paginate['baseUrl']    = action( 'Admin\CategoryController@index' );

        $count = $this->categoryRepository->count();
        $categorys = $this->categoryRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.categories.index',
            [
                'categorys'    => $categorys,
                'count'         => $count,
                'paginate'      => $paginate,
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
            'pages.admin.' . config('view.admin') . '.categories.edit',
            [
                'isNew'     => true,
                'category' => $this->categoryRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(CategoryRequest $request)
    {
        $input = $request->only(['name','description']);
                $input['type'] = $request->get('type', 0);

        $category = $this->categoryRepository->create($input);

        if (empty( $category )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');

            $newImage = $this->fileUploadService->upload(
                'category_cover_image',
                $file,
                [
                    'entity_type' => 'category_cover_image',
                    'entity_id'   => $category->id,
                    'title'       => $category->name,
                ]
            );

            if (!empty($newImage)) {
                $this->categoryRepository->update($category, ['cover_image_id' => $newImage->id]);
            }
        } else {
            $imageUrl = $request->get('image_url', '');
            if( $imageUrl != '' ) {
                $newImage = $this->imageRepository->create(
                    [
                        'url'      => $imageUrl,
                        'is_local' => false
                    ]
                );

                if (!empty($newImage)) {
                    $this->categoryRepository->update($category, ['cover_image_id' => $newImage->id]);
                }
            }
        }

        return redirect()->action('Admin\CategoryController@index')
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
        $category = $this->categoryRepository->find($id);
        $storeApps = $this->storeApplicationRepository->getStoreAppWithOutCategory($id);
        if (empty( $category )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.categories.edit',
            [
                'isNew' => false,
                'category' => $category,
                'storeApps' => $storeApps,
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
    public function update($id, CategoryRequest $request)
    {
        /** @var \App\Models\Category $category */
        $category = $this->categoryRepository->find($id);
        if (empty( $category )) {
            abort(404);
        }
        $input = $request->only(['name','description']);
        $input['type'] = $request->get('type', 0);

        if ($request->hasFile('cover_image')) {
            $currentImage = $category->coverImage;
            $file = $request->file('cover_image');

            $newImage = $this->fileUploadService->upload(
                'category_cover_image',
                $file,
                [
                    'entity_type' => 'category_cover_image',
                    'entity_id'   => $category->id,
                    'title'       => $request->input('name', ''),
                ]
            );

            if (!empty($newImage)) {
                $input['cover_image_id'] = $newImage->id;

                if (!empty($currentImage)) {
                    $this->fileUploadService->delete($currentImage);
                }
            }
        } else {
            $imageUrl = $request->get('image_url', '');
            if( $imageUrl != '' ) {
                $currentImage = $category->coverImage;
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
                    $input['cover_image_id'] = $image->id;
                }
            }
        }

        $this->categoryRepository->update($category, $input);

        return redirect()->action('Admin\CategoryController@show', [$id])
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
        /** @var \App\Models\Category $category */
        $category = $this->categoryRepository->find($id);
        if (empty( $category )) {
            abort(404);
        }
        $this->categoryRepository->delete($category);

        return redirect()->action('Admin\CategoryController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

    public function deleteStoreApp($id, $appId)
    {
        $storeApp = $this->storeApplicationRepository->findByCategoryIdAndId($id, $appId);
        if (empty($storeApp)) {
            abort(404);
        }

        $this->storeApplicationRepository->delete($storeApp);

        return redirect()->back()->with('message-success', trans('admin.messages.general.delete_success'));
    }

    public function addStoreApp($id, CategoryRequest $request)
    {
        $category = $this->categoryRepository->find($id);
        if (empty( $category )) {
            abort(404);
        }

        $storeApps = $request->get('new-storeApp', []);
        foreach( $storeApps as $appId ) {
            $check = $this->storeApplicationRepository->findByCategoryIdAndId($category->id, $appId);
            if( empty($check) ) {
                $storeApp = $this->storeApplicationRepository->find($appId);
                $this->storeApplicationRepository->update($storeApp, ['category_id' => $id]);
            }
        }

        return redirect()->action('Admin\CategoryController@show', [$id])->with('message-success', trans('admin.messages.general.update_success'));
    }
}
