@extends('layouts.admin.' . config('view.admin') . '.application', ['menu' => 'singers'] )

@section('metadata')
@stop

@section('styles')
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/datetimepicker/css/bootstrap-datetimepicker.min.css', 'admin') !!}">
    <link rel="stylesheet" href="{!! \URLHelper::asset('libs/plugins/select2/select2.min.css', 'admin') !!}">
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
        });
    </script>
@stop

@section('title')
@stop

@section('header')
    Singers
@stop

@section('breadcrumb')
    <li><a href="{!! action('Admin\SingerController@index') !!}"><i class="fa fa-files-o"></i> Singers</a></li>
    @if( $isNew )
        <li class="active">New</li>
    @else
        <li class="active">{{ $singer->id }}</li>
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

    <form action="@if($isNew) {!! action('Admin\SingerController@store') !!} @else {!! action('Admin\SingerController@update', [$singer->id]) !!} @endif" method="POST" enctype="multipart/form-data">
        @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
        {!! csrf_field() !!}

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="{!! URL::action('Admin\SingerController@index') !!}" class="btn btn-block btn-default btn-sm" style="width: 125px;">@lang('admin.pages.common.buttons.back')</a>
                </h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group text-center">
                            @if( !empty($singer->coverImage) )
                                <img id="cover-image-preview" style="max-width: 500px; width: 100%;" src="{!! $singer->coverImage->present()->url !!}" alt="" class="margin"/>
                            @else
                                <img id="cover-image-preview" style="max-width: 500px; width: 100%;" src="{!! \URLHelper::asset('img/no_image.jpg', 'common') !!}" alt="" class="margin"/>
                            @endif

                            <input type="file" style="display: none;" id="cover-image" name="cover_image">
                            <p class="help-block" style="font-weight: bolder;">
                                Cover Image
                                <label for="cover-image" style="font-weight: 100; color: #549cca; margin-left: 10px; cursor: pointer;">@lang('admin.pages.common.buttons.edit')</label>
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <table class="edit-user-profile">
                            <tr class="@if ($errors->has('willcard')) has-error @endif">
                                <td>
                                    <label for="wildcard">@lang('admin.pages.songs.columns.wildcard')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="wildcard" name="wildcard" required value="{{ old('wildcard') ? old('wildcard') : $singer->wildcard }}">
                                </td>
                            </tr>
                            <tr class="@if ($errors->has('name')) has-error @endif">
                                <td>
                                    <label for="name">@lang('admin.pages.genres.columns.name')</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') ? old('name') : $singer->name }}">
                                </td>
                            </tr>
                            <tr class="@if ($errors->has('image_url')) has-error @endif">
                                <td>
                                    <label for="image_url">Image URL</label>
                                </td>
                                <td>
                                    <input type="text" class="form-control" id="image_url" name="image_url" value="{{ old('image_url') ? old('image_url') : (!empty($song->coverImage) ? $song->coverImage->present()->url : '') }}">
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group @if ($errors->has('description')) has-error @endif">
                            <label for="description">@lang('admin.pages.singers.columns.description')</label>
                            <textarea name="description" class="form-control" rows="5" placeholder="@lang('admin.pages.singers.columns.description')">{{ old('description') ? old('description') : $singer->description }}</textarea>
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
                    @foreach( $singer->songs as $index => $song )
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
                                <a href="{{ action('Admin\SingerController@deleteSong', [$singer->id, $song->id]) }}" >@lang('admin.pages.common.buttons.delete')</a>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="box-footer">
                <form action="{!! action('Admin\SingerController@addNewSong', $singer->id) !!}" method="POST">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="new-songs">Add New Song</label>
                                <select class="form-control new-songs" name="new-songs[]" required id="new-songs" style="margin-bottom: 15px;" multiple="multiple">

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
