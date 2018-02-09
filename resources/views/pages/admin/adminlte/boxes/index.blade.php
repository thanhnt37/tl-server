@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'boxes'] )

@section('metadata')
@stop

@section('styles')
    <style>
        #box-index tr td {
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
            <div class="col-sm-12">

                <h3 class="box-title">
                    <p class="text-right">
                        <a href="{!! action('Admin\BoxController@create') !!}" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.create')</a>
                        <label for="file-upload" class="btn btn-success btn-sm" style="width: 125px;">Import List</label>
                    </p>
                </h3>

                <form action="{{ action('Admin\BoxController@confirmUploadImei') }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="file" name="file-upload" id="file-upload" style="display: none;" onchange="this.form.submit()">
                </form>
            </div>
            <div class="col-sm-6">
                <form method="get" accept-charset="utf-8" action="{!! action('Admin\BoxController@index') !!}">
                    {!! csrf_field() !!}
                    <div class="row search-input">
                        <div class="col-md-12" style="margin-bottom: 10px;">
                            <div class="search-input-text">
                                <input type="text" name="keyword" class="form-control" placeholder="Search here" id="keyword" value="{{$keyword}}">
                                <button type="submit" class="btn">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                <p style="display: inline-block;">@lang('admin.pages.common.label.search_results', ['count' => $count])</p>
            </div>
            <div class="col-sm-6 wrap-top-pagination">
                <div class="heading-page-pagination" style="margin-top: 0;">
                    {!! \PaginationHelper::render($paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'], $count, $paginate['baseUrl'], ['keyword' => $keyword], $count, 'shared.topPagination') !!}
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
                <th>{!! \PaginationHelper::sort('model', 'Box Type') !!}</th>
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
                            <a href="{!! action('Admin\BoxVersionController@show', $box->boxVersion->id) !!}">{!! $box->boxVersion->name !!}</a>
                        @else
                            Unknown
                        @endif
                    </td>
                    <td>
                        @if(isset($box->osVersion->name))
                            <a href="{!! action('Admin\OsVersionController@show', $box->osVersion->id) !!}">{!! $box->osVersion->name !!}</a>
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
        {!! \PaginationHelper::render($paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'], $count, $paginate['baseUrl'], ['keyword' => $keyword]) !!}
    </div>
</div>
@stop