@extends('voyager::master')
@section('content')

    <style>
        table,td,th {
            text-align: center;
            direction: rtl;
        }
        .table {
            margin-left: 10px;
        }
    </style>
    <br>
    @if(isset($key) && $key=='course')
        <table class="table table-striped">
            <thead>
            <tr>
                <th>نام</th>
                <th>ایمیل</th>
                <th>قیمت</th>
                <th>کد تخفیف</th>
            </tr>
            </thead>
            <tbody>

            @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->paid}}</td>
                    <td>{{$user->discount_used}}</td>
                </tr>
            @endforeach


            </tbody>
        </table>
    @endif
    @if(isset($key) && $key=='pack')
        <table class="table table-striped">
            <thead>
            <tr>
                <th>نام</th>
                <th>ایمیل</th>
                <th>قیمت</th>
                <th>کد تخفیف</th>
                <th>شروع </th>
                <th>پایان</th>
            </tr>
            </thead>
            <tbody>

            @foreach($users as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->paid}}</td>
                    <td>{{$user->discount_used}}</td>
                    <td>{{$user->start}}</td>
                    <td>{{$user->end}}</td>
                </tr>
            @endforeach


            </tbody>
        </table>
    @endif

@stop