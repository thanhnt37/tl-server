@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'songs'] )

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
Songs
@stop

@section('breadcrumb')
<li class="active">Songs</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">

        <div class="row">
            <div class="col-sm-6">
                <h3 class="box-title">
                    <p class="text-right">
                        <a href="{!! action('Admin\SongController@create') !!}" class="btn btn-block btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.create')</a>
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
                <th>{!! \PaginationHelper::sort('code', trans('admin.pages.songs.columns.code')) !!}</th>
                <th>{!! \PaginationHelper::sort('wildcard', trans('admin.pages.songs.columns.wildcard')) !!}</th>
                <th>{!! \PaginationHelper::sort('name', trans('admin.pages.songs.columns.name')) !!}</th>
                <th>{!! \PaginationHelper::sort('mode_play', 'Mode Play') !!}</th>
                <th>{!! \PaginationHelper::sort('vote', trans('admin.pages.songs.columns.vote')) !!}</th>
                <th>{!! \PaginationHelper::sort('vote', trans('admin.pages.songs.columns.view')) !!}</th>

                <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
            </tr>
            @foreach( $songs as $song )
                <tr>
                    <td>{{ $song->id }}</td>
                    <td>{{ $song->code }}</td>
                    <td>{{ $song->wildcard }}</td>
                    <td>{{ $song->name }}</td>
                    <td>
                        @if($song->mode_play)
                            Online
                        @else
                            Offline
                        @endif
                    </td>
                    <td>{{ $song->vote }}</td>
                    <td>{{ $song->view }}</td>

                    <td>
                        <a href="{!! action('Admin\SongController@show', $song->id) !!}"
                           class="btn btn-block btn-primary btn-xs">@lang('admin.pages.common.buttons.edit')</a>
                        <a href="#" class="btn btn-block btn-danger btn-xs delete-button"
                           data-delete-url="{!! action('Admin\SongController@destroy', $song->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
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