<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\AuthorRepositoryInterface;
use App\Http\Requests\Admin\AuthorRequest;
use App\Http\Requests\PaginationRequest;

class AuthorController extends Controller
{

    /** @var \App\Repositories\AuthorRepositoryInterface */
    protected $authorRepository;


    public function __construct(
        AuthorRepositoryInterface $authorRepository
    )
    {
        $this->authorRepository = $authorRepository;
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
        $paginate['baseUrl']    = action( 'Admin\AuthorController@index' );

        $count = $this->authorRepository->count();
        $authors = $this->authorRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.authors.index',
            [
                'authors'  => $authors,
                'count'    => $count,
                'paginate' => $paginate,
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
            'pages.admin.' . config('view.admin') . '.authors.edit',
            [
                'isNew'  => true,
                'author' => $this->authorRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(AuthorRequest $request)
    {
        $input = $request->only(['name','description','image']);

        $author = $this->authorRepository->create($input);

        if (empty( $author )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\AuthorController@index')
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
        $author = $this->authorRepository->find($id);
        if (empty( $author )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.authors.edit',
            [
                'isNew'  => false,
                'author' => $author,
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
    public function update($id, AuthorRequest $request)
    {
        /** @var \App\Models\Author $author */
        $author = $this->authorRepository->find($id);
        if (empty( $author )) {
            abort(404);
        }
        $input = $request->only(['name','description','image']);
        
        $this->authorRepository->update($author, $input);

        return redirect()->action('Admin\AuthorController@show', [$id])
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
        /** @var \App\Models\Author $author */
        $author = $this->authorRepository->find($id);
        if (empty( $author )) {
            abort(404);
        }
        $this->authorRepository->delete($author);

        return redirect()->action('Admin\AuthorController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
