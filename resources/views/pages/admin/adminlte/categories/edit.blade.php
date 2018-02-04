@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'categories'] )

@section('metadata')
@stop

@section('styles')
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css', 'admin') !!}">
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/plugins/select2/select2.min.css', 'admin') !!}">
    <style>
        .album-songs tr td:nth-child(5){
            text-align: center;
        }
    </style>
@stop

@section('scripts')
    <script src="{{ \URLHelper::asset('libs/moment/moment.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/datetimepicker/js/bootstrap-datetimepicker.min.js', 'admin') }}"></script>
    <script src="{{ \URLHelper::asset('libs/plugins/select2/select2.full.min.js', 'admin') }}"></script>
    <script>
        $('.datetime-field').datetimepicker({'format': 'YYYY-MM-DD HH:mm:ss', 'defaultDate': new Date()});

        $(document).ready(function () {
            $(".new-categories").select2();

            $("#cover-image").change(function (event) {
                $("#cover-image-preview").attr("src", URL.createObjectURL(event.target.files[0]));
            });
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    Categories
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\CategoryController@index') !!}"><i class="fa fa-files-o"></i> Categories</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $category->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\CategoryController@store') !!} @else {!! action('Admin\CategoryController@update', [$category->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\CategoryController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('name')) has-error @endif">
                                <label for="name">@lang('admin.pages.categories.columns.name')</label>
                                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ? old('name') : $category->name }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('image_url')) has-error @endif">
                                <label for="image_url">Image URL</label>
                                <input type="text" class="form-control" id="image_url" name="image_url" value="{{ old('image_url') ? old('image_url') : (!empty($category->coverImage) ? $category->coverImage->present()->url : '') }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        @lang('admin.pages.categories.columns.type')
                                    </label>
                                    <div class="switch">
                                        <input id="is_activated" name="type" value="1" @if( $category->type == 1) checked
                                               @endif class="cmn-toggle cmn-toggle-round-flat" type="checkbox">
                                        <label for="is_activated"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group @if ($errors->has('description')) has-error @endif">
                                <label for="description">@lang('admin.pages.categories.columns.description')</label>
                                <textarea name="description" class="form-control" rows="5" required placeholder="@lang('admin.pages.categories.columns.description')">{{ old('description') ? old('description') : $category->description }}</textarea>
                            </div>
                        </div>
                    </div>
    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group text-center">
                                @if( !empty($category->coverImage) )
                                    <img id="cover-image-preview"  style="max-width: 500px; width: 100%;" src="{!! $category->present()->coverImage->present()->url !!}" alt="" class="margin" />
                                @else
                                    <img id="cover-image-preview" style="max-width: 500px; width: 100%;" src="{!! \URLHelper::asset('img/no_image.jpg', 'common') !!}" alt="" class="margin" />
                                @endif
                                <input type="file" style="display: none;"  id="cover-image" name="cover_image">
                                <p class="help-block" style="font-weight: bolder;">
                                    Cover Image
                                    <label for="cover-image" style="font-weight: 100; color: #549cca; margin-left: 10px; cursor: pointer;">@lang('admin.pages.common.buttons.edit')</label>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
                </div>
            </form>
            @if(!$isNew)
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title text-center" style="display: block; font-weight: bold">
                                Store Application
                            </h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered album-songs">
                                <tr>
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Version Name</th>
                                    <th>Version Code</th>
                                    <th>Hit</th>
                                    <th>Action</th>
                                </tr>
                                @foreach( $category->storeApplication as $index => $storeApplication )
                                    <tr>
                                        <td>{{$index + 1}}</td>
                                        <td>
                                            {{ $storeApplication['name'] }}
                                        </td>
                                        <td>{{ $storeApplication['version_name'] }}</td>
                                        <td>{{ $storeApplication['version_code'] }}</td>
                                        <td> {{ $storeApplication['hit'] }} </td>
                                        <td>
                                            <a href="{{ action('Admin\CategoryController@deleteStoreApp', [$category->id, $storeApplication['id'] ]) }}" >
                                            @lang('admin.pages.common.buttons.delete')</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <form action="{!! action('Admin\CategoryController@addStoreApp', $category->id) !!}" method="POST">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="employee-id">Add New Store Application</label>
                                <select class="form-control new-categories" name="new-storeApp[]" required id="new-songs" style="margin-bottom: 15px;" multiple="multiple">
                                    @foreach( $storeApps as $index => $storeApp )
                                        <option value="{!! $storeApp->id !!}">
                                            {{ $storeApp->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
                </form>
            </div>
            @endif()
        </div>
    </div>
@stop
