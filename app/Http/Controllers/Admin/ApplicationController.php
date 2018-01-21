<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\ApplicationRepositoryInterface;
use App\Http\Requests\Admin\ApplicationRequest;
use App\Http\Requests\PaginationRequest;
use Illuminate\Support\Facades\Hash;

class ApplicationController extends Controller
{

    /** @var \App\Repositories\ApplicationRepositoryInterface */
    protected $applicationRepository;


    public function __construct(
        ApplicationRepositoryInterface $applicationRepository
    )
    {
        $this->applicationRepository = $applicationRepository;
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
        $paginate['order']      = $request->order('id');
        $paginate['direction']  = $request->direction('asc');
        $paginate['baseUrl']    = action( 'Admin\ApplicationController@index' );

        $count = $this->applicationRepository->count();
        $applications = $this->applicationRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.applications.index',
            [
                'applications' => $applications,
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
            'pages.admin.' . config('view.admin') . '.applications.edit',
            [
                'isNew'       => true,
                'application' => $this->applicationRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(ApplicationRequest $request)
    {
        $input = $request->only(['name']);
        $input['is_blocked'] = $request->get('is_blocked', 0);

        $input['app_key'] = Hash::make($input['name']);

        $application = $this->applicationRepository->create($input);

        if (empty( $application )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\ApplicationController@index')
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
        $application = $this->applicationRepository->find($id);
        if (empty( $application )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.applications.edit',
            [
                'isNew'       => false,
                'application' => $application,
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
    public function update($id, ApplicationRequest $request)
    {
        /** @var \App\Models\Application $application */
        $application = $this->applicationRepository->find($id);
        if (empty( $application )) {
            abort(404);
        }
        $input = $request->only(['name','app_key']);
        $input['is_blocked'] = $request->get('is_blocked', 0);
        
        $this->applicationRepository->update($application, $input);

        return redirect()->action('Admin\ApplicationController@show', [$id])
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
        /** @var \App\Models\Application $application */
        $application = $this->applicationRepository->find($id);
        if (empty( $application )) {
            abort(404);
        }
        $this->applicationRepository->delete($application);

        return redirect()->action('Admin\ApplicationController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
