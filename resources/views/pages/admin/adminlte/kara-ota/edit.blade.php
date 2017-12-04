@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'kara_ota'] )

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
    </script>
@stop

@section('title')
@stop

@section('header')
    KaraOta
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\KaraOtaController@index') !!}"><i class="fa fa-files-o"></i> KaraOta</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $karaOta->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\KaraOtaController@store') !!} @else {!! action('Admin\KaraOtaController@update', [$karaOta->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\KaraOtaController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group @if ($errors->has('os_version')) has-error @endif">
                            <label for="os_version">@lang('admin.pages.kara-ota.columns.os_version')</label>
                            <input type="text" class="form-control" id="os_version" name="os_version" required
                                   value="{{ old('os_version') ? old('os_version') : $karaOta->os_version }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @if ($errors->has('box_version')) has-error @endif">
                            <label for="box_version">@lang('admin.pages.kara-ota.columns.box_version')</label>
                            <input type="text" class="form-control" id="box_version" name="box_version" required
                                   value="{{ old('box_version') ? old('box_version') : $karaOta->box_version }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group @if ($errors->has('kara_version_id')) has-error @endif">
                            <label for="box_version">@lang('admin.pages.kara-ota.columns.kara_version_id')</label>
                            <select class="form-control" name="kara_version_id" id="kara_version_id" required>
                                @foreach( $karaVersions as $karaVersion )
                                    <option value="{!! $karaVersion->id !!}" @if( (old('kara_version_id') && old('kara_version_id') == $karaVersion->id) || ( $karaOta->kara_version_id == $karaVersion->id) ) selected @endif >
                                        {{ $karaVersion->version }}
                                    </option>
                                @endforeach
                            </select>
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
