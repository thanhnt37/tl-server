@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'store_applications'] )

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
StoreApplications
@stop

@section('breadcrumb')
<li class="active">StoreApplications</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">

        <div class="row">
            <div class="col-sm-6">
                <h3 class="box-title">
                    <p class="text-right">
                        <a href="{!! action('Admin\StoreApplicationController@create') !!}" class="btn btn-block btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.create')</a>
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
                <th>{!! \PaginationHelper::sort('name', trans('admin.pages.store-applications.columns.name')) !!}</th>
                <th>{!! \PaginationHelper::sort('version_name', trans('admin.pages.store-applications.columns.version_name')) !!}</th>
                <th>{!! \PaginationHelper::sort('version_code', trans('admin.pages.store-applications.columns.version_code')) !!}</th>
                <th>{!! \PaginationHelper::sort('hit', trans('admin.pages.store-applications.columns.hit')) !!}</th>
                <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
            </tr>
            @foreach( $storeApplications as $storeApplication )
                <tr>
                    <td>{{ $storeApplication->id }}</td>
                    <td>{{ $storeApplication->name }}</td>
                    <td>{{ $storeApplication->version_name }}</td>
                    <td>{{ $storeApplication->version_code }}</td>
                    <td>{{ $storeApplication->hit }}</td>
                    <td>
                        <a href="{!! action('Admin\StoreApplicationController@show', $storeApplication->id) !!}"
                           class="btn btn-block btn-primary btn-xs">@lang('admin.pages.common.buttons.edit')</a>
                        <a href="#" class="btn btn-block btn-danger btn-xs delete-button"
                           data-delete-url="{!! action('Admin\StoreApplicationController@destroy', $storeApplication->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
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