@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'app_versions'] )

@section('metadata')
@stop

@section('styles')
    <style>
        #app-version-index tr td {
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
App Versions
@stop

@section('breadcrumb')
<li class="active">App Versions</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">

        <div class="row">
            <div class="col-sm-6">
                <h3 class="box-title">
                    <p class="text-right">
                        <a href="{!! action('Admin\AppVersionController@create') !!}" class="btn btn-block btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.create')</a>
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
        @foreach( $applications as $application )
            <table class="table table-bordered" style="margin-bottom: 30px;" id="app-version-index">
                <tr>
                    <th colspan="6" style="background: #88d8cb7d;">{{$application->name}}</th>
                </tr>
                <tr>
                    <th style="width: 10px">{!! \PaginationHelper::sort('id', 'ID') !!}</th>
                    <th>{!! \PaginationHelper::sort('application_id', 'Application') !!}</th>
                    <th>{!! \PaginationHelper::sort('version', 'Version Code') !!}</th>
                    <th>{!! \PaginationHelper::sort('name', trans('admin.pages.kara-versions.columns.name')) !!}</th>
                    <th>{!! \PaginationHelper::sort('apk_url', trans('admin.pages.kara-versions.columns.apk_url')) !!}</th>

                    <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
                </tr>
                @foreach( $karaVersions as $karaVersion )
                    @if( isset($karaVersion->application_id) && ($karaVersion->application_id == $application->id ) )
                        <tr>
                            <td>{{ $karaVersion->id }}</td>
                            <td>{{ !empty($karaVersion->application) ? $karaVersion->application->name : 'Unknown' }}</td>
                            <td>{{ $karaVersion->version }}</td>
                            <td>{{ $karaVersion->name }}</td>
                            <td>
                                {{ isset($karaVersion->apkPackage->url) ? (\URLHelper::asset(config('file.categories.kara_apk.local_path') . $karaVersion->apkPackage->url, config('file.categories.kara_apk.local_type'))) : 'Unknown' }}
                            </td>

                            <td>
                                <a href="{!! action('Admin\AppVersionController@show', $karaVersion->id) !!}"
                                   class="btn btn-block btn-primary btn-xs">@lang('admin.pages.common.buttons.edit')</a>
                                <a href="#" class="btn btn-block btn-danger btn-xs delete-button"
                                   data-delete-url="{!! action('Admin\AppVersionController@destroy', $karaVersion->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>
        @endforeach
    </div>
    <div class="box-footer">
        {!! \PaginationHelper::render($paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'], $count, $paginate['baseUrl'], []) !!}
    </div>
</div>
@stop