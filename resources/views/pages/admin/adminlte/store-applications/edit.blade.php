@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'store_applications'] )

@section('metadata')
@stop

@section('styles')
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css', 'admin') !!}">
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css', 'admin') !!}">
    <style>
        .bootstrap-tagsinput {
            display: block;
        }
    </style>
@stop

@section('scripts')
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js', 'admin') }}"></script>
    <script>
        $('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss', 'defaultDate': new Date()});

        $(document).ready(function () {
            $("#icon-image").change(function (event) {
                $("#icon-image-preview").attr("src", URL.createObjectURL(event.target.files[0]));
            });
            $("#background-image").change(function (event) {
                $("#background-image-preview").attr("src", URL.createObjectURL(event.target.files[0]));
            });
            $('#apk_package').change(function (event) {
                $('#apk_url').val(event.target.files[0].name);
            });
            $('#tags').tagsinput({
                tagClass: 'tags-abc'
            });
            $('#edit-store_applications').on('keyup keypress', function(e) {
                var keyCode = e.keyCode || e.which;
                if (keyCode === 13) {
                    e.preventDefault();
                    return false;
                }
            });
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    StoreApplications
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\StoreApplicationController@index') !!}"><i class="fa fa-files-o"></i> StoreApplications</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $storeApplication->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\StoreApplicationController@store') !!} @else {!! action('Admin\StoreApplicationController@update', [$storeApplication->id]) !!} @endif" method="POST" enctype="multipart/form-data" id="edit-store_applications">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\StoreApplicationController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group @if ($errors->has('icon_image_url')) has-error @endif">
                            <label for="icon_image_url">Icon Image URL</label>
                            <input type="text" class="form-control" id="icon_image_url" name="icon_image_url" value="{{ old('icon_image_url') ? old('icon_image_url') : (!empty($storeApplication->iconImage) ? $storeApplication->iconImage->present()->url : '') }}">
                        </div>

                        <div class="form-group text-center">
                            @if( !empty($storeApplication->iconImage) )
                                <img id="icon-image-preview" style="max-width: 500px; width: 100%;" src="{!! $storeApplication->iconImage->present()->url !!}" alt="" />
                            @else
                                <img id="icon-image-preview" style="max-width: 500px; width: 100%;" src="{!! \URLHelper::asset('img/no_image.jpg', 'common') !!}" alt="" />
                            @endif

                            <input type="file" style="display: none;" id="icon-image" name="icon_image">
                            <p class="help-block" style="font-weight: bolder;">
                                Icon Image
                                <label for="icon-image" style="font-weight: 100; color: #549cca; margin-left: 10px; cursor: pointer;">@lang('admin.pages.common.buttons.edit')</label>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group @if ($errors->has('background_image_url')) has-error @endif">
                            <label for="background_image_url">Background Image URL</label>
                            <input type="text" class="form-control" id="background_image_url" name="background_image_url" value="{{ old('background_image_url') ? old('background_image_url') : (!empty($storeApplication->backgroundImage) ? $storeApplication->backgroundImage->present()->url : '') }}">
                        </div>

                        <div class="form-group text-center">
                            @if( !empty($storeApplication->backgroundImage) )
                                <img id="background-image-preview" style="max-width: 500px; width: 100%;" src="{!! $storeApplication->backgroundImage->present()->url !!}" alt=""/>
                            @else
                                <img id="background-image-preview" style="max-width: 500px; width: 100%;" src="{!! \URLHelper::asset('img/no_image.jpg', 'common') !!}" alt=""/>
                            @endif

                            <input type="file" style="display: none;" id="background-image" name="background_image">
                            <p class="help-block" style="font-weight: bolder;">
                                Background Image
                                <label for="background-image" style="font-weight: 100; color: #549cca; margin-left: 10px; cursor: pointer;">@lang('admin.pages.common.buttons.edit')</label>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('name')) has-error @endif">
                            <label for="name">@lang('admin.pages.store-applications.columns.name')</label>
                            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ? old('name') : $storeApplication->name }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('version_name')) has-error @endif">
                            <label for="version_name">@lang('admin.pages.store-applications.columns.version_name')</label>
                            <input type="text" class="form-control" id="version_name" name="version_name" required value="{{ old('version_name') ? old('version_name') : $storeApplication->version_name }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('version_code')) has-error @endif">
                            <label for="version_code">@lang('admin.pages.store-applications.columns.version_code')</label>
                            <input type="text" class="form-control" id="version_code" name="version_code" required value="{{ old('version_code') ? old('version_code') : $storeApplication->version_code }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('package_name')) has-error @endif">
                            <label for="package_name">@lang('admin.pages.store-applications.columns.package_name')</label>
                            <input type="text" class="form-control" id="package_name" name="package_name" required value="{{ old('package_name') ? old('package_name') : $storeApplication->package_name }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('min_sdk')) has-error @endif">
                            <label for="min_sdk">Min SDK</label>
                            <input type="text" class="form-control" id="min_sdk" name="min_sdk" required value="{{ old('min_sdk') ? old('min_sdk') : $storeApplication->min_sdk }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('category_id')) has-error @endif">
                            <label for="hit">@lang('admin.pages.store-applications.columns.category_id')</label>

                            <select class="form-control" name="category_id" id="category_id" required style="margin-bottom: 15px;">
                                @foreach( $categories as $category )
                                    <option value="{!! $category->id !!}" @if( (old('category_id') && old('category_id') == $category->id) || ( $storeApplication->category_id == $category->id) ) selected @endif >
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('developer_id')) has-error @endif">
                            <label for="hit">@lang('admin.pages.store-applications.columns.developer_id')</label>

                            <select class="form-control" name="developer_id" id="developer_id" required style="margin-bottom: 15px;">
                                @foreach( $developers as $developer )
                                    <option value="{!! $developer->id !!}" @if( (old('developer_id') && old('developer_id') == $developer->id) || ( $storeApplication->developer_id == $developer->id) ) selected @endif >
                                        {{ $developer->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('hit')) has-error @endif">
                            <label for="hit">@lang('admin.pages.store-applications.columns.hit')</label>
                            <input type="number" min="0" class="form-control" id="hit" name="hit" required value="{{ old('hit') ? old('hit') : $storeApplication->hit }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="publish_started_at">@lang('admin.pages.store-applications.columns.publish_started_at')</label>
                            <div class="input-group date datetime-field">
                                <input type="text" class="form-control" name="publish_started_at" required
                                     value="{{ old('publish_started_at') ? old('publish_started_at') : $storeApplication->publish_started_at }}">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('tags')) has-error @endif">
                            <label for="tags">Tags</label>
                            <input data-role="tagsinput" name="tags" id="tags" class="form-control" value="{{ old('tags') ? old('tags') : $storeApplication->tags }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('description')) has-error @endif">
                            <label for="description">@lang('admin.pages.store-applications.columns.description')</label>
                            <textarea name="description" class="form-control" rows="5" required placeholder="@lang('admin.pages.store-applications.columns.description')">{{ old('description') ? old('description') : $storeApplication->description }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-11">
                        <div class="form-group @if ($errors->has('apk_url')) has-error @endif">
                            <label for="apk_url" class="help-block">APK Package</label>
                            <input type="text" class="form-control" id="apk_url" name="apk_url" value="{{ isset($storeApplication->apkPackage->url) ? $storeApplication->apkPackage->url : '' }}" disabled style="display: inline-block; width: 90%;">

                            <label for="apk_package" style="font-weight: 100; color: #549cca; margin-left: 10px; cursor: pointer;">Upload</label>
                            <input type="file" style="display: none;" id="apk_package" name="apk_package">
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
