@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'authors'] )

@section('metadata')
@stop

@section('styles')
    <style>
        #authors-index tr td {
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
Authors
@stop

@section('breadcrumb')
<li class="active">Authors</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">

        <div class="row">
            <div class="col-sm-6">
                <h3 class="box-title">
                    <p class="text-right">
                        <a href="{!! action('Admin\AuthorController@create') !!}" class="btn btn-block btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.create')</a>
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
        <table class="table table-bordered" id="authors-index">
            <tr>
                <th style="width: 10px">{!! \PaginationHelper::sort('id', 'ID') !!}</th>
                <th>{!! \PaginationHelper::sort('name', trans('admin.pages.authors.columns.name')) !!}</th>
                <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
            </tr>
            @foreach( $authors as $author )
                <tr>
                    <td>{{ $author->id }}</td>
                    <td>{{ $author->name }}</td>
                    <td>
                        <a href="{!! action('Admin\AuthorController@show', $author->id) !!}"
                           class="btn btn-block btn-primary btn-xs">@lang('admin.pages.common.buttons.edit')</a>
                        <a href="#" class="btn btn-block btn-danger btn-xs delete-button"
                           data-delete-url="{!! action('Admin\AuthorController@destroy', $author->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
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