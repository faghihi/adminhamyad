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
        <a href="#" class="list-group-item">First item<br>
            <input type="button" class="btn btn-primary" value="edit" > <input type="button" class="btn btn-success" value="browse">
        </a>
        <a href="#" class="list-group-item">Second item<br>
            <input type="button" class="btn btn-primary" value="edit" > <input type="button" class="btn btn-success" value="browse">
        </a>
        <a href="#" class="list-group-item">Third item<br>
            <input type="button" class="btn btn-primary" value="edit" > <input type="button" class="btn btn-success" value="browse">
        </a>
    </div>
@stop