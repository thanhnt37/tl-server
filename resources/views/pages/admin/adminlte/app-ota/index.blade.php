@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'app_ota'] )

@section('metadata')
@stop

@section('styles')
    <style>
        #app-ota-index tr td {
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
    App OTA
@stop

@section('breadcrumb')
<li class="active">App OTA</li>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">

        <div class="row">
            <div class="col-sm-6">
                <h3 class="box-title">
                    <p class="text-right">
                        <a href="{!! action('Admin\AppOtaController@create') !!}" class="btn btn-block btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.create')</a>
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
    <div class="box-body" style=" overflow-x: scroll; " id="app-ota-index">
        @foreach( $applications as $application )
            <table class="table table-bordered" style="margin-bottom: 30px;">
                <tr>
                    <th colspan="6" style="background: #88d8cb7d;">{{$application->name}}</th>
                </tr>
                <tr>
                    <th style="width: 10px">{!! \PaginationHelper::sort('id', 'ID') !!}</th>
                    <th>{!! \PaginationHelper::sort('os_version', 'Box Type') !!}</th>
                    <th>{!! \PaginationHelper::sort('os_version', trans('admin.pages.kara-ota.columns.os_version')) !!}</th>
                    <th>{!! \PaginationHelper::sort('sdk_version', trans('admin.pages.kara-ota.columns.sdk_version')) !!}</th>
                    <th>App Versions</th>

                    <th style="width: 40px">@lang('admin.pages.common.label.actions')</th>
                </tr>
                @foreach( $karaOtas as $karaOta )
                    @if( isset($karaOta->karaVersion->application_id) && ($karaOta->karaVersion->application_id == $application->id ) )
                        <tr>
                            <td>{{ $karaOta->id }}</td>
                            <td>
                                @if(isset($karaOta->boxVersion->name))
                                    <a href="{!! action('Admin\BoxVersionController@show', $karaOta->boxVersion->id) !!}">{!! $karaOta->boxVersion->name !!}</a>
                                @else
                                    Unknown
                                @endif
                            </td>
                            <td>
                                @if(isset($karaOta->osVersion->name))
                                    <a href="{!! action('Admin\OsVersionController@show', $karaOta->osVersion->id) !!}">{!! $karaOta->osVersion->name !!}</a>
                                @else
                                    Unknown
                                @endif
                            </td>
                            <td>
                                @if(isset($karaOta->sdkVersion->name))
                                    <a href="{!! action('Admin\SdkVersionController@show', $karaOta->sdkVersion->id) !!}">{!! $karaOta->sdkVersion->name !!}</a>
                                @else
                                    Unknown
                                @endif
                            </td>

                            <td>
                                @if( isset($karaOta->karaVersion->version) )
                                    <a href="{{action('Admin\AppVersionController@show', [$karaOta->karaVersion->id])}}">{{$karaOta->karaVersion->version}}</a>
                                @else
                                    Unknown
                                @endif
                            </td>

                            <td>
                                <a href="{!! action('Admin\AppOtaController@show', $karaOta->id) !!}"
                                   class="btn btn-block btn-primary btn-xs">@lang('admin.pages.common.buttons.edit')</a>
                                <a href="#" class="btn btn-block btn-danger btn-xs delete-button"
                                   data-delete-url="{!! action('Admin\AppOtaController@destroy', $karaOta->id) !!}">@lang('admin.pages.common.buttons.delete')</a>
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