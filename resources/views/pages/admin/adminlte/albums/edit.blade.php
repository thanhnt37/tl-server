@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'albums'] )

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
            $(".new-songs").select2({
                placeholder: "Choose new song to album",
                allowClear: true,
                ajax: {
                    delay: 500,
                    url: function (params) {
                        return '{{action('Admin\SongController@search')}}';
                    },
                    data: function (params) {
                        return {
                            keyword: params.term
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.data
                        };
                    }
                },
                cache: true
            });

            $('#cover-image').change(function (event) {
                $('#cover-image-preview').attr('src', URL.createObjectURL(event.target.files[0]));
            });
            $('#background-image').change(function (event) {
                $('#background-image-preview').attr('src', URL.createObjectURL(event.target.files[0]));
            });
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    Albums
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\AlbumController@index') !!}"><i class="fa fa-files-o"></i> Albums</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $album->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\AlbumController@store') !!} @else {!! action('Admin\AlbumController@update', [$album->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\AlbumController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group @if ($errors->has('cover_image_url')) has-error @endif">
                                    <label for="cover_image_url">Cover Image URL</label>
                                    <input type="text" class="form-control" id="cover_image_url" name="cover_image_url" value="{{ old('cover_image_url') ? old('cover_image_url') : (!empty($album->coverImage) ? $album->coverImage->present()->url : '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            @if( !empty($album->coverImage) )
                                <img id="cover-image-preview" style="max-width: 500px; width: 100%;" src="{!! $album->coverImage->present()->url !!}" alt="" />
                            @else
                                <img id="cover-image-preview" style="max-width: 500px; width: 100%;" src="{!! \URLHelper::asset('img/no_image.jpg', 'common') !!}" alt="" />
                            @endif

                            <input type="file" style="display: none;" id="cover-image" name="cover_image">
                            <p class="help-block" style="font-weight: bolder;">
                                Cover Image
                                <label for="cover-image" style="font-weight: 100; color: #549cca; margin-left: 10px; cursor: pointer;">@lang('admin.pages.common.buttons.edit')</label>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group @if ($errors->has('background_image_url')) has-error @endif">
                                    <label for="background_image_url">Background Image URL</label>
                                    <input type="text" class="form-control" id="background_image_url" name="background_image_url" value="{{ old('background_image_url') ? old('background_image_url') : (!empty($album->backgroundImage) ? $album->backgroundImage->present()->url : '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            @if( !empty($album->backgroundImage) )
                                <img id="background-image-preview" style="max-width: 500px; width: 100%;" src="{!! $album->backgroundImage->present()->url !!}" alt=""/>
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
                            <label for="name">@lang('admin.pages.albums.columns.name')</label>
                            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ? old('name') : $album->name }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('publish_at')) has-error @endif">
                            <label for="publish_at">@lang('admin.pages.albums.columns.publish_at')</label>

                            <div class="input-group date datetime-field">
                                <input type="text" class="form-control" id="publish_at" name="publish_at" value="{{ old('publish_at') ? old('publish_at') : $album->publish_at }}" style="margin-bottom: 0">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group @if ($errors->has('vote')) has-error @endif">
                            <label for="vote">@lang('admin.pages.albums.columns.vote')</label>
                            <input type="number" min="0" class="form-control" id="vote" name="vote" value="{{ old('vote') ? old('vote') : $album->vote }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('description')) has-error @endif">
                            <label for="description">@lang('admin.pages.albums.columns.description')</label>
                            <textarea name="description" class="form-control" rows="5" required
                                      placeholder="@lang('admin.pages.albums.columns.description')">{{ old('description') ? old('description') : $album->description }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
            </div>
        </div>
    </form>

    @if( !$isNew )
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title text-center" style="display: block; font-weight: bold">
                    Songs
                </h3>
            </div>

            <div class="box-body">
                <table class="table table-bordered album-songs">
                    <tr>
                        <th>No.</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Vote</th>
                        <th>Actions</th>
                    </tr>
                    @foreach( $album->songs as $index => $song )
                        <tr>
                            <td>{{$index}}</td>
                            <td>
                                <a href="{!! action('Admin\SongController@show', $song->id) !!}">{{$song->code}}</a>
                            </td>
                            <td>
                                <a href="{!! action('Admin\SongController@show', $song->id) !!}">{{$song->name}}</a>
                            </td>
                            <td>{{$song->vote}}</td>
                            <td>
                                <a href="{{ action('Admin\AlbumController@deleteSong', [$album->id, $song->id]) }}" >@lang('admin.pages.common.buttons.delete')</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="box-footer">
                <form action="{!! action('Admin\AlbumController@addNewSong', $album->id) !!}" method="POST">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="employee-id">Add New Song</label>
                                <select class="form-control new-songs" name="new-songs[]" required id="new-songs" style="margin-bottom: 15px;" multiple="multiple">
                                    {{--@foreach( $songs as $index => $song )--}}
                                        {{--<option value="{!! $song->id !!}">--}}
                                            {{--{{ $song->name }}--}}
                                        {{--</option>--}}
                                    {{--@endforeach--}}
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.save')</button>
                </form>
            </div>
        </div>
    @endif
@stop
