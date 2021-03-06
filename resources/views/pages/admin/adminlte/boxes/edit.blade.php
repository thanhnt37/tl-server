@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'boxes'] )

@section('metadata')
@stop

@section('styles')
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css', 'admin') !!}">
@stop

@section('scripts')
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
    <script>
        $('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss', 'defaultDate': new Date()});

        $(document).ready(function () {
        });

        function confirmUploadImei() {
            $('#confirm-os_version_id').val($('#os_version_id').find(":selected").val());
            $('#confirm-sdk_version_id').val($('#sdk_version_id').find(":selected").val());
            $('#confirm-box_version_id').val($('#box_version_id').find(":selected").val());

            $('#confirmUploadImei').submit();
        }
    </script>
@stop

@section('title')
@stop

@section('header')
    Boxes
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\BoxController@index') !!}"><i class="fa fa-files-o"></i> Boxes</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $box->id }}</li>
    @endif
@stop

@section('content')
    @if (count($errors) > 0)
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="confirmUploadImei" action="{{ action('Admin\BoxController@confirmUploadImei') }}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="file" name="file-upload" id="file-upload" style="display: none;" onchange="confirmUploadImei()">

        <input type="hidden" id="confirm-os_version_id" name="confirm-os_version_id">
        <input type="hidden" id="confirm-sdk_version_id" name="confirm-sdk_version_id">
        <input type="hidden" id="confirm-box_version_id" name="confirm-box_version_id">
    </form>

    <form action="@if($isNew) {!! action('Admin\BoxController@store') !!} @else {!! action('Admin\BoxController@update', [$box->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\BoxController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px; display: inline-block;">@lang('admin.pages.common.buttons.back')</a>
                    <label for="file-upload" class="btn btn-success btn-sm" style="width: 125px;">Import List</label>
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group @if ($errors->has('os_version_id')) has-error @endif">
                            <label for="os_version_id">@lang('admin.pages.boxes.columns.os_version_id')</label>
                            <select class="form-control" name="os_version_id" id="os_version_id" required>
                                @foreach( $osVersions as $osVersion )
                                    <option value="{!! $osVersion->id !!}" @if( (old('os_version_id') && old('os_version_id') == $osVersion->id) || ( $box->os_version_id == $osVersion->id) || ($osVersion->id == \Session::get('os_version_id')) ) selected @endif >
                                        {{ $osVersion->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @if ($errors->has('sdk_version_id')) has-error @endif">
                            <label for="sdk_version_id">@lang('admin.pages.boxes.columns.sdk_version_id')</label>
                            <select class="form-control" name="sdk_version_id" id="sdk_version_id" required>
                                @foreach( $sdkVersions as $sdkVersion )
                                    <option value="{!! $sdkVersion->id !!}" @if( (old('sdk_version_id') && old('sdk_version_id') == $sdkVersion->id) || ( $box->sdk_version_id == $sdkVersion->id) || ($sdkVersion->id == \Session::get('sdk_version_id')) ) selected @endif >
                                        {{ $sdkVersion->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group @if ($errors->has('box_version_id')) has-error @endif">
                            <label for="box_version_id">Box Type</label>
                            <select class="form-control" name="box_version_id" id="box_version_id" required>
                                @foreach( $boxVersions as $boxVersion )
                                    <option value="{!! $boxVersion->id !!}" @if( (old('box_version_id') && old('box_version_id') == $boxVersion->id) || ( $box->box_version_id == $boxVersion->id) || ($boxVersion->id == \Session::get('box_version_id')) ) selected @endif >
                                        {{ $boxVersion->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('imei')) has-error @endif">
                            <label for="imei">@lang('admin.pages.boxes.columns.imei')</label>
                            <input type="text" class="form-control" id="imei" name="imei" autofocus required
                                   value="{{ old('imei') ? old('imei') : $box->imei }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('serial')) has-error @endif">
                            <label for="serial">@lang('admin.pages.boxes.columns.serial')</label>
                            <input type="text" class="form-control" id="serial" name="serial" required
                                   value="{{ old('serial') ? old('serial') : $box->serial }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="activation_date">@lang('admin.pages.boxes.columns.activation_date')</label>
                            <div class="input-group date datetime-field">
                                <input type="text" class="form-control" name="activation_date" value="{{ old('activation_date') ? old('activation_date') : $box->activation_date }}">
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="is_activated">@lang('admin.pages.boxes.columns.is_activated')</label>
                            <div class="switch">
                                <input id="is_activated" name="is_activated" value="1" @if( $box->is_activated) checked
                                       @endif class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
                                <label for="is_activated"></label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="is_blocked">@lang('admin.pages.boxes.columns.is_blocked')</label>
                            <div class="switch">
                                <input id="is_blocked" name="is_blocked" value="1" @if( $box->is_blocked) checked @endif class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
                                <label for="is_blocked"></label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
            </div>
        </div>
    </form>
@stop
