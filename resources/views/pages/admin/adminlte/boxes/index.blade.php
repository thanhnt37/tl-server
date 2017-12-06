@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'boxes'] )

@section('metadata')
@stop

@section('styles')
    <style>
        #box-index tr td:nth-of-type(6) {
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
Boxes
@stop

@section('breadcrumb')
<li class="active">Boxes</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">

        <div class="row">
            <div class="col-sm-6">
                <h3 class="box-title">
                    <p class="text-right">
                        <a href="{!! action('Admin\BoxController@create') !!}" class="btn btn-block btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.create')</a>
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
        <table class="table table-bordered" id="box-index">
            <tr>
                <th style="width: 10px">{!! \PaginationHelper::sort('id', 'ID') !!}</th>
                <th>{!! \PaginationHelper::sort('imei', trans('admin.pages.boxes.columns.imei')) !!}</th>
                <th>{!! \PaginationHelper::sort('serial', trans('admin.pages.boxes.columns.serial')) !!}</th>
                <th>{!! \PaginationHelper::sort('model', trans('admin.pages.boxes.columns.box_version_id')) !!}</th>
                <th>{!! \PaginationHelper::sort('os_version', trans('admin.pages.boxes.columns.os_version_id')) !!}</th>
                <th width="85px">{!! \PaginationHelper::sort('is_activated', trans('admin.pages.boxes.columns.is_activated')) !!}</th>

                <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
            </tr>
            @foreach( $boxs as $box )
                <tr>
                    <td>{{ $box->id }}</td>
                    <td>{{ $box->imei }}</td>
                    <td>{{ $box->serial }}</td>
                    <td>
                        @if(isset($box->boxVersion->name))
                            <a href="{!! action('Admin\OsVersionController@show', $box->osVersion->id) !!}">{!! $box->osVersion->name !!}</a>
                        @else
                            Unknown
                        @endif
                    </td>
                    <td>
                        @if(isset($box->osVersion->name))
                            <a href="{!! action('Admin\BoxVersionController@show', $box->boxVersion->id) !!}">{!! $box->boxVersion->name !!}</a>
                        @else
                            Unknown
                        @endif
                    </td>

                    <td>
                        @if( $box->is_activated )
                            <span class="badge bg-green">@lang('admin.pages.boxes.columns.activate')</span>
                        @else
                            <span class="badge bg-red">@lang('admin.pages.boxes.columns.deactivate')</span>
                        @endif
                    </td>

                    <td>
                        <a href="{!! action('Admin\BoxController@show', $box->id) !!}" class="btn btn-block btn-primary btn-xs">@lang('admin.pages.common.buttons.edit')</a>
                        <a href="#" class="btn btn-block btn-danger btn-xs delete-button" data-delete-url="{!! action('Admin\BoxController@destroy', $box->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
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