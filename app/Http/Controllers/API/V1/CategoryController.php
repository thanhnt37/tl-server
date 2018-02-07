<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseRequest;
use App\Http\Responses\API\V1\Response;
use App\Repositories\CategoryRepositoryInterface;

class CategoryController extends Controller
{
    /** @var \App\Repositories\AlbumRepositoryInterface */
    protected $categoryRepository;

    public function __construct(
        CategoryRepositoryInterface    $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    public function lists(BaseRequest $request)
    {
        $categories = $this->categoryRepository->all();
        foreach( $categories as $key => $category ) {
            $storeApps = $category->storeApplication()->get();
            foreach ( $storeApps as $key2 => $app ) {
                $storeApps[$key2] = $app->toAPIArray();
            }

            $category = $category->toAPIArray();
            $category['app_list'] = $storeApps->toArray();
            
            $categories[$key] = $category;
        }
        
        return Response::response(200, $categories);
    }
}
