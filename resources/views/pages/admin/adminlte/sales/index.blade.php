@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'sales'] )

@section('metadata')
@stop

@section('styles')
@stop

@section('scripts')
<script src="{!! \URLHelper::asset('js/delete_item.js', 'admin') !!}"></script>
@stop

@section('title')
@stop

@section('header')
Sales
@stop

@section('breadcrumb')
<li class="active">Sales</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">

        <div class="row">
            <div class="col-sm-6">
                <h3 class="box-title">
                    <p class="text-right">
                        <a href="{!! action('Admin\SaleController@create') !!}" class="btn btn-block btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.create')</a>
                    </p>
                </h3>
                <br>
                <p style="display: inline-block;">@lang('admin.pages.common.label.search_results', ['count' => $count])</p>
            </div>
            <div class="col-sm-6 wrap-top-pagination">
                <div class="heading-page-pagination">
                    {!! \PaginationHelper::render($paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'], $count, $paginate['baseUrl'], [], $count, 'shared.topPagination') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="box-body" style=" overflow-x: scroll; ">
        <table class="table table-bordered">
            <tr>
                <th style="width: 10px">{!! \PaginationHelper::sort('id', 'ID') !!}</th>
                <th>{!! \PaginationHelper::sort('customer_id', trans('admin.pages.sales.columns.customer_id')) !!}</th>
                <th>{!! \PaginationHelper::sort('box_id', trans('admin.pages.sales.columns.box_id')) !!}</th>

                <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
            </tr>
            @foreach( $sales as $sale )
                <tr>
                    <td>{{ $sale->id }}</td>

                    <td>
                        @if(isset($sale->customer->name))
                            <a href="{!! action('Admin\CustomerController@show', $sale->customer->id) !!}">{!! $sale->customer->name !!}</a>
                        @else
                            Unknown
                        @endif
                    </td>

                    <td>
                        @if(isset($sale->box->serial))
                            <a href="{!! action('Admin\BoxController@show', $sale->box->id) !!}">{!! $sale->box->serial !!}</a>
                        @else
                            Unknown
                        @endif
                    </td>

                    <td>
                        <a href="{!! action('Admin\SaleController@show', $sale->id) !!}" class="btn btn-block btn-primary btn-xs">@lang('admin.pages.common.buttons.edit')</a>
                        <a href="#" class="btn btn-block btn-danger btn-xs delete-button" data-delete-url="{!! action('Admin\SaleController@destroy', $sale->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="box-footer">
        {!! \PaginationHelper::render($paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'], $count, $paginate['baseUrl'], []) !!}
    </div>
</div>
@stop