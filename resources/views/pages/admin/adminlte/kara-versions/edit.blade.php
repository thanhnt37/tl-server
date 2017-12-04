@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'kara_versions'] )

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
            $('#apk_package').change(function (event) {
                $('#apk_url').val(event.target.files[0].name);
            });
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    KaraVersions
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\KaraVersionController@index') !!}"><i class="fa fa-files-o"></i> KaraVersions</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $karaVersion->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\KaraVersionController@store') !!} @else {!! action('Admin\KaraVersionController@update', [$karaVersion->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\KaraVersionController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('version')) has-error @endif">
                            <label for="version">@lang('admin.pages.kara-versions.columns.version')</label>
                            <input type="text" class="form-control" id="version" name="version" required value="{{ old('version') ? old('version') : $karaVersion->version }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="name">@lang('admin.pages.kara-versions.columns.name')</label>
                            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ? old('name') : $karaVersion->name }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group @if ($errors->has('apk_url')) has-error @endif">
                            <label for="apk_url" class="help-block">@lang('admin.pages.kara-versions.columns.apk_url')</label>
                            <input type="text" class="form-control" id="apk_url" name="apk_url" value="{{ isset($karaVersion->apkPackage->url) ? $karaVersion->apkPackage->url : '' }}" disabled style="display: inline-block; width: 90%;">

                            <label for="apk_package" style="font-weight: 100; color: #549cca; margin-left: 10px; cursor: pointer;">Upload</label>
                            <input type="file" style="display: none;" id="apk_package" name="apk_package">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('description')) has-error @endif">
                            <label for="description">@lang('admin.pages.kara-versions.columns.description')</label>
                            <textarea name="description" class="form-control" rows="5"
                                      placeholder="@lang('admin.pages.kara-versions.columns.description')">{{ old('description') ? old('description') : $karaVersion->description }}</textarea>
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
