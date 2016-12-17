@extends('voyager::master')

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> Viewing {{ ucfirst($dataType->display_name_singular) }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered" style="padding-bottom:5px;">


                    <!-- /.box-header -->
                    <!-- form start -->


                    @foreach($dataType->readRows as $row)

                        <div class="panel-heading" style="border-bottom:0;">
                            <h3 class="panel-title">{{ $row->display_name }}</h3>
                        </div>

                        <div class="panel-body" style="padding-top:0;">

                                @if($row->type == 'image')
                                    <img src="@if( strpos($dataTypeContent->{$row->field}, 'http://') === false && strpos($dataTypeContent->{$row->field}, 'https://') === false){{ Voyager::image( $dataTypeContent->{$row->field} ) }}@else{{ $dataTypeContent->{$row->field} }}@endif" style="width:100px">

                                @elseif($row->display_name == Config::get('settings.discount') && $dataType->slug ==  'discount' && $dataTypeContent->{$row->field} == 0)
                                   <p>درصد</p>
                                @elseif($row->display_name == Config::get('settings.discount') && $dataType->slug ==  'discount' && $dataTypeContent->{$row->field} == 1)
                                    <p>نقدی</p>

                                @elseif($row->display_name == Config::get('settings.enable') && $dataType->slug ==  'reviews' && $dataTypeContent->{$row->field} == 0)
                                    تایید نشده
                                @elseif($row->display_name == Config::get('settings.enable') && $dataType->slug ==  'reviews' && $dataTypeContent->{$row->field} == 1)
                                    تایید شده

                                @elseif( in_array($row->display_name, Config::get('settings.prices_list')))
                                    @if($dataTypeContent->{$row->field} > 1000)
                                        <?php $price=$dataTypeContent->{$row->field}/1000 . ' هزار تومان'?>
                                    @else
                                        <?php $price=$dataTypeContent->{$row->field} . ' تومان'?>
                                    @endif
                                    <p>{{$price}}</p>
                                @else
                                    <p>{{ $dataTypeContent->{$row->field} }}</p>
                                @endif
                        </div><!-- panel-body -->
                        @if(!$loop->last)
                            <hr style="margin:0;">
                        @endif
                    @endforeach


                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')

@stop