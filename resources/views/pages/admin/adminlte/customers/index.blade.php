@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'customers'] )

@section('metadata')
@stop

@section('styles')
    <style>
        #customers-index tr td {
            text-align: center;
        }
    </style>
@stop

@section('scripts')
<script src="{!! \URLHelper::asset('js/delete_item.js', 'admin') !!}"></script>
@stop

@section('title')
@stop

@section('header')
Customers
@stop

@section('breadcrumb')
<li class="active">Customers</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">

        <div class="row">
            <div class="col-sm-6">
                <h3 class="box-title">
                    <p class="text-right">
                        <a href="{!! action('Admin\CustomerController@create') !!}" class="btn btn-block btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.create')</a>
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
        <table class="table table-bordered" id="customers-index">
            <tr>
                <th style="width: 10px">{!! \PaginationHelper::sort('id', 'ID') !!}</th>
                <th>{!! \PaginationHelper::sort('name', trans('admin.pages.customers.columns.name')) !!}</th>
                <th>{!! \PaginationHelper::sort('email', trans('admin.pages.customers.columns.email')) !!}</th>
                <th>{!! \PaginationHelper::sort('telephone', trans('admin.pages.customers.columns.telephone')) !!}</th>
                <th>{!! \PaginationHelper::sort('area', trans('admin.pages.customers.columns.area')) !!}</th>
                <th>{!! \PaginationHelper::sort('agency', trans('admin.pages.customers.columns.agency')) !!}</th>

                <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
            </tr>
            @foreach( $customers as $customer )
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->telephone }}</td>
                    <td>{{ $customer->area }}</td>
                    <td>{{ $customer->agency }}</td>

                    <td>
                        <a href="{!! action('Admin\CustomerController@show', $customer->id) !!}"
                           class="btn btn-block btn-primary btn-xs">@lang('admin.pages.common.buttons.edit')</a>
                        <a href="#" class="btn btn-block btn-danger btn-xs delete-button"
                           data-delete-url="{!! action('Admin\CustomerController@destroy', $customer->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
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