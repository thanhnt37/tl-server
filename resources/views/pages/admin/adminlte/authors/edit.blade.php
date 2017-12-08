@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'authors'] )

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
    Authors
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\AuthorController@index') !!}"><i class="fa fa-files-o"></i> Authors</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $author->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\AuthorController@store') !!} @else {!! action('Admin\AuthorController@update', [$author->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\AuthorController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group text-center">
                            @if( !empty($author->image) )
                                <img id="profile-image-preview" style="max-width: 500px; width: 100%;" src="{!! $author->image !!}" alt="" class="margin"/>
                            @else
                                <img id="profile-image-preview" style="max-width: 500px; width: 100%;" src="{!! \URLHelper::asset('img/no_image.jpg', 'common') !!}" alt="" class="margin"/>
                            @endif
                            <input type="file" style="display: none;" id="cover-image" name="cover_image">
                            <p class="help-block" style="font-weight: bolder;">Cover Image </p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <table class="edit-user-profile">
                            <tr class="@if ($errors->has('name')) has-error @endif">
                                <td>
                                    <label for="name">@lang('admin.pages.authors.columns.name')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ? old('name') : $author->name }}">
                                </td>
                            </tr>
                            <tr class="@if ($errors->has('image')) has-error @endif">
                                <td>
                                    <label for="image">@lang('admin.pages.authors.columns.image')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="image" name="image" value="{{ old('image') ? old('image') : $author->image }}" style="margin-top: 15px;">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('description')) has-error @endif">
                            <label for="description">@lang('admin.pages.authors.columns.description')</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="@lang('admin.pages.authors.columns.description')">{{ old('description') ? old('description') : $author->description }}</textarea>
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
