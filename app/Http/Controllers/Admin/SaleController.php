<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\SaleRepositoryInterface;
use App\Http\Requests\Admin\SaleRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\BoxRepositoryInterface;

class SaleController extends Controller
{
    /** @var \App\Repositories\SaleRepositoryInterface */
    protected $saleRepository;

    /** @var \App\Repositories\CustomerRepositoryInterface */
    protected $customerRepository;

    /** @var \App\Repositories\BoxRepositoryInterface */
    protected $boxRepository;

    public function __construct(
        SaleRepositoryInterface     $saleRepository,
        CustomerRepositoryInterface $customerRepository,
        BoxRepositoryInterface      $boxRepository
    )
    {
        $this->saleRepository       = $saleRepository;
        $this->customerRepository   = $customerRepository;
        $this->boxRepository        = $boxRepository;
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
        $paginate['baseUrl']    = action( 'Admin\SaleController@index' );

        $count = $this->saleRepository->count();
        $sales = $this->saleRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.sales.index',
            [
                'sales'    => $sales,
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
            'pages.admin.' . config('view.admin') . '.sales.edit',
            [
                'isNew'     => true,
                'sale'      => $this->saleRepository->getBlankModel(),
                'customers' => $this->customerRepository->all()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(SaleRequest $request)
    {
        $input = $request->only(['customer_id', 'serial']);

        $box = $this->boxRepository->findBySerial($input['serial']);
        if( empty($box) ) {
            return redirect()->back()->withErrors('Error, Serial number not exist !!!');
        }

        \Session::put('customer_id', $input['customer_id']);

        $sale = $this->saleRepository->create(
            [
                'customer_id' => $input['customer_id'],
                'box_id'      => $box->id
            ]
        );


        if (empty( $sale )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\SaleController@index')
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
        $sale = $this->saleRepository->find($id);
        if (empty( $sale )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.sales.edit',
            [
                'isNew'     => false,
                'sale'      => $sale,
                'customers' => $this->customerRepository->all()
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
    public function update($id, SaleRequest $request)
    {
        /** @var \App\Models\Sale $sale */
        $sale = $this->saleRepository->find($id);
        if (empty( $sale )) {
            abort(404);
        }
        $input = $request->only(['customer_id', 'serial']);

        $box = $this->boxRepository->findBySerial($input['serial']);
        if( empty($box) ) {
            return redirect()->back()->withErrors('Error, Serial number not exist !!!');
        }

        $this->saleRepository->update(
            $sale,
            [
                'customer_id' => $input['customer_id'],
                'box_id'      => $box->id
            ]
        );

        \Session::put('customer_id', $input['customer_id']);

        return redirect()->action('Admin\SaleController@show', [$id])
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
        /** @var \App\Models\Sale $sale */
        $sale = $this->saleRepository->find($id);
        if (empty( $sale )) {
            abort(404);
        }
        $this->saleRepository->delete($sale);

        return redirect()->action('Admin\SaleController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
