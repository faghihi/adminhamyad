@extends('voyager::master')

@section('css')
    <link href="{{ config('voyager.assets_path') }}/ExtraLib/jquery.tagit.css" rel="stylesheet" type="text/css">
    <link href="{{ config('voyager.assets_path') }}/ExtraLib/tagit.ui-zendesk.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="{{ config('voyager.assets_path') }}/ExtraLib/tag-it.js" type="text/javascript" charset="utf-8"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ config('voyager.assets_path') }}/css/media/media.css"/>
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/js/select2/select2.min.css">
    <link rel="stylesheet" href="{{ config('voyager.assets_path') }}/css/media/dropzone.css"/>
    <style>
        .panel-body {
            direction: rtl;
        }
    </style>
    <style>
        .panel .mce-panel {
            border-left-color: #fff;
            border-right-color: #fff;
        }

        .panel .mce-toolbar,
        .panel .mce-statusbar {
            padding-left: 20px;
        }

        .panel .mce-edit-area,
        .panel .mce-edit-area iframe,
        .panel .mce-edit-area iframe html {
            padding: 0 10px;
            min-height: 350px;
        }

        .mce-content-body {
            color: #555;
            font-size: 14px;
        }

        .panel.is-fullscreen .mce-statusbar {
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .panel.is-fullscreen .mce-tinymce {
            height:100%;
        }

        .panel.is-fullscreen .mce-edit-area,
        .panel.is-fullscreen .mce-edit-area iframe,
        .panel.is-fullscreen .mce-edit-area iframe html {
            height: 100%;
            position: absolute;
            width: 95%;
            overflow-y: scroll;
            overflow-x: hidden;
            min-height: 100%;
        }

        .nav .open>a, .nav .open>a:focus, .nav .open>a:hover {

            direction: rtl;
        }
        .nav-tabs>li>a {
            direction: rtl;
        }
        .section:focus {
            text-decoration: none;
        }
        a:focus {
            text-decoration: none;
        }
        .panel-collapse {
            direction: rtl;
        }
        .panel-body {
            direction: rtl;
        }
    </style>
@stop

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> @if(isset($dataTypeContent->id)){{ 'Edit' }}@else{{ 'New' }}@endif {{ $dataType->display_name_singular }}
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        <form onsubmit="return ajaxthings()" role="form" action="@if(isset($dataTypeContent->id)){{ route('courses.update', $dataTypeContent->id) }}@else{{ route('courses.store') }}@endif" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8">
                    <!-- ### TITLE ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                <i class="voyager-character"></i> Name
                                <span class="panel-desc"> عنوان دوره </span>
                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <input type="text" class="form-control" name="name" placeholder="اسم دوره" value="@if(isset($dataTypeContent->name)){{ $dataTypeContent->name }}@endif">
                        </div>
                    </div>

                    <!-- ### CONTENT ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-book"></i>توضیحات</h3>
                            <div class="panel-actions">
                                <a class="panel-action icon wb-expand" data-toggle="panel-fullscreen" aria-hidden="true"></a>
                            </div>
                        </div>
                        <textarea class="richTextBox" name="description" style="border:0px;">
                            @if(isset($dataTypeContent->description)){{ $dataTypeContent->description }}@endif
                        </textarea>
                    </div><!-- .panel -->

                    <!-- ### EXCERPT ### -->
                    <div class="panel">
                        <div class="panel-heading">
                            <h3 class="panel-title">برچسب ها
                            </h3>
                            <div class="panel-actions">
                                <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div>
                            @foreach(\App\Tag::all() as $tag)
                                {{$tag->id}}
                                {{$tag->tag_name}}
                                /
                            @endforeach

                        </div>
                        <?php $tagss=\App\Tag::all();?>

                            <input name="tags" id="singleFieldTags2" value="
                            @if (isset($dataTypeContent->tags))
                            @foreach($dataTypeContent->tags as $tag)
                            {{$tag->tag_name}}
                                    , @endforeach
                            @endif">
                        <script> var fruits = [];</script>
                        @if(isset($tagss))
                            @foreach(\App\Tag::all() as $tag)
                                <script>
                                    fruits.push("{{$tag->tag_name}}");
                                </script>
                            @endforeach
                        @endif
                        <script>
                            $(function(){
                                $('#singleFieldTags2').tagit({
                                    availableTags: fruits
                                });
                            });
                        </script>

                        <br>

                    </div>
                    <div>
                        <div class="panel-group" id="accordion">
                            @if(isset($dataTypeContent->id))
                            @foreach($dataTypeContent->section as $sec)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                       {{$sec->name}}
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{$sec->id}}" style="float: left;"><span class="caret"></span></a>
                                    </h4>
                                </div>
                                <div id="collapse{{$sec->id}}" class="panel-collapse collapse in">
                                    <div class="panel-body"><p>{{$sec['time']}} دقیقه</p>
                                        <p>قسمت {{$sec['part']}}</p>
                                    </div>
                                    <div class="panel-footer"><a href="{{url('/admin/sections/'.$sec->id.'/edit')}}"><input type="button" class="btn btn-primary" value="edit"></a><a href="{{url('/admin/sections/'.$sec->id)}}"> <input type="button" class="btn btn-success" value="browse"></a></div>
                                </div>
                            </div>
                            @endforeach
                                @endif
                        </div>
                            <br>
                        @if(isset($dataTypeContent->id))
                      {{--<a href="{{url('/admin/sections/create')}}"><button type="button" class="btn btn-primary" id="addSection"><i class="voyager-new"></i>--}}
                            {{--افزودن--}}
                        {{--</button></a>--}}
                            @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- ### DETAILS ### -->
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-clipboard"></i>موضوع اصلی دوره</h3>
                            <div class="panel-actions">
                                <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">انتخاب موضوع</label>
                                <select class="form-control" name="category_id">
                                    @foreach(\App\Category::all() as $category)
                                        <option value="{{ $category->id }}" @if(isset($dataTypeContent->category_id) && $dataTypeContent->category_id == $category->id){{ 'selected="selected"' }}@endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- ### IMAGE ### -->
                    <div class="panel panel-bordered panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-image"></i>تصویر دوره</h3>
                            <div class="panel-actions">
                                <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            @if(isset($dataTypeContent->image))
                                <img src="{{url('/storage'.$dataTypeContent->image )}}" style="width:100%" />
                            @endif
                                <input type="text" name="image" class="Chooser"  value="@if(isset($dataTypeContent->id)){{$dataTypeContent->{'image'} }} @endif">
                                <button type="button" class="btn btn-default" id="choose"><i class="voyager-character"></i>
                                    انتخاب از فایل های سرور
                                </button>
                        </div>
                    </div>

                    <!-- ### SEO CONTENT ### -->
                    <div class="panel panel-bordered panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-search"></i>قیمت گذاری</h3>
                            <div class="panel-actions">
                                <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">Price</label>
                                <input type="number" class="form-control" name="price" value="@if(isset($dataTypeContent->price)){{ $dataTypeContent->price }}@endif">
                            </div>
                        </div>
                    </div>

                    {{--Producer --}}
                    <?php
                        if(isset($dataTypeContent->id)){
                            $course=\App\Course::find($dataTypeContent->id);
                            $provider=$course->provider;
                        }
                        ?>
                    <div class="panel panel panel-bordered panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon wb-clipboard"></i>تولید کننده</h3>
                            <div class="panel-actions">
                                <a class="panel-action icon wb-minus" data-toggle="panel-collapse" aria-hidden="true"></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">انتخاب تولید کننده</label>
                                <select class="form-control" name="provider_id">
                                    @foreach(\App\Provider::all() as $p)
                                        <option value="{{ $p->id }}" @if(! empty($provider[0]) && $provider[0]['id'] == $p->id){{ 'selected="selected"' }}@endif>{{ $p->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PUT Method if we are editing -->
            @if(isset($dataTypeContent->id))
                <input type="hidden" name="_method" value="PUT">
        @endif
        <!-- PUT Method if we are editing -->
            <div id="courseId" hidden> @if(isset($dataTypeContent->id)){{$dataTypeContent->id}}@endif</div>

            <button type="submit" class="btn btn-primary pull-right">
                @if(isset($dataTypeContent->id)){{ 'آپدیت اطلاعات دوره' }}@else<?= '<i class="icon wb-plus-circle"></i> ساخت دوره ی جدید'; ?>@endif
            </button>
        </form>

        <iframe id="form_target" name="form_target" style="display:none"></iframe>
        <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
            {{ csrf_field() }}
            <input name="image" id="upload_file" type="file" onchange="$('#my_form').submit();this.value='';">
            <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
        </form>
    </div>



    @include('filemodal')


    {{--    @include('addsectionmodal',array('dataTypeContent'=>$dataTypeContent));--}}
@stop

@section('javascript')
    <script>
        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();
        });
    </script>
    <script src="{{ config('voyager.assets_path') }}/lib/js/tinymce/tinymce.min.js"></script>
    <script src="{{ config('voyager.assets_path') }}/js/voyager_tinymce.js"></script>
    <script src="{{ config('voyager.assets_path') }}/js/select2/select2.min.js"></script>
    <script src="{{ config('voyager.assets_path') }}/js/media/dropzone.js"></script>
    <script src="{{ config('voyager.assets_path') }}/js/media/media.js"></script>
    <script type="text/javascript">
        var media = new VoyagerMedia({
            baseUrl: "{{ route('voyager.dashboard') }}"
        });
        $(function () {
            media.init();
        });
        function alerts(e) {
            var model=$('.selected .details a').text()
            if(model=='folder'){
                toastr.error('not possible', "Whoops!");
            }
            else
            {
                var ok=$('.selected .details p').text();
                ok=ok.split('/');
                var str ="";
                for (var i=2; i< ok.length; i++){
                    if(i==1)
                        str +=ok[i];
                    else
                        str+='/'+ok[i];
                }
                $('.Chooser').val(str);
                toastr.success('selected', "Sweet Success!");
                $('#choose_file_modal').modal('hide');
            }

        }

        function ajaxthings() {
            var tags=$('input[name="tags"]').val();
            console.log(tags);
            return true;
        }
        {{--function addsection(e){--}}
            {{--var conceptName = $('#new_sectionName').find(":selected").val();--}}
            {{--var CourseId = $('#courseId').text();--}}
            {{--var t=e.target;--}}
            {{--var url = $(t).attr('data-link');--}}

            {{--//add it to your data--}}
            {{--var data = {--}}
                {{--_token:$(this).data('token'),--}}
                {{--conceptName : conceptName,--}}
                {{--courseId : CourseId--}}
            {{--};--}}
            {{--console.log(CourseId);--}}
            {{--console.log(url);--}}
            {{--console.log(conceptName);--}}

            {{--$.ajax({--}}
                {{--url: url,--}}
                {{--type:"POST",--}}
                {{--data: data,--}}
                {{--success:function(data){--}}
                    {{--// alert(data.msg);--}}
                    {{--if(data.msg==1){--}}
                        {{--toastr.error('not possible', "Whoops!");--}}
                    {{--}--}}
                    {{--if(data.msg==2){--}}
                        {{--toastr.error('not possibllllle', "Whoops!");--}}
                    {{--}--}}
                    {{--if(data.msg==3){--}}
                        {{--toastr.success('selected', "Sweet Success!");--}}
                        {{--$('#add_course_modal').modal('hide');--}}
                    {{--}--}}

                {{--},error:function(){--}}
                    {{--toastr.error('not Connection', "Whoops!");--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}
        {{--$('#addSection').click(function(){--}}
            {{--$('#add_section_modal').modal('show');--}}
        {{--});--}}

        $('#choose').click(function(){
            $('#choose_file_modal').modal('show');
        });

    </script>
@stop

