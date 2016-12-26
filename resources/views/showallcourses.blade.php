@extends('voyager::master')
@section('content')
    <style>
        .list-group {
            margin-left: 20px;
            margin-top: 20px;
            direction: rtl;
        }

    </style>
    <div class="list-group">
        <?php $count=0;?>
        @foreach($courses as $course)
            <?php $count=1;?>
            <a href="#" class="list-group-item">{{$course['name']}} <br>
                <a href="{{url("/admin/courses/".$course['id'].'/edit')}}"><input type="button" class="btn btn-primary" value="edit" ></a> <a href="{{url("/admin/courses/".$course['id'])}}"><input type="button" class="btn btn-success" value="browse"></a>
            </a>
        @endforeach
        @if(!$count)
            داده ای برای نمایش وجود ندارد .
            @endif
    </div>
@stop