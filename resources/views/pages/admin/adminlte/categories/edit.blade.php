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
                    <div class="col-lg-5">
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

                    <div class="col-lg-7">
                        <table class="edit-user-profile">
                            <tr class="@if ($errors->has('name')) has-error @endif">
                                <td>
                                    <label for="name">@lang('admin.pages.categories.columns.name')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ? old('name') : $category->name }}">
                                </td>
                            </tr>
                            <tr class="@if ($errors->has('type')) has-error @endif">
                                <td>
                                    <label for="type">@lang('admin.pages.categories.columns.type')</label>
                                </td>
                                <td>
                                    <select class="form-control" name="type" id="type" style="margin-bottom: 15px;" required>
                                        <option value="{{\App\Models\Category::CATEGORY_TYPE_APP}}" @if(!$category->type) selected @endif>Applications</option>
                                        <option value="{{\App\Models\Category::CATEGORY_TYPE_GAME}}" @if($category->type) selected @endif>Games</option>
                                    </select>
                                </td>
                            </tr>
                            <tr class="@if ($errors->has('image_url')) has-error @endif">
                                <td>
                                    <label for="image_url">Image URL</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="image_url" name="image_url" value="{{ old('image_url') ? old('image_url') : (!empty($category->coverImage) ? $category->coverImage->present()->url : '') }}">
                                </td>
                            </tr>
                        </table>
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
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
            </div>
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
    @endif
@stop
