@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ config('voyager.assets_path') }}/css/media/media.css"/>
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/js/select2/select2.min.css">
    <link rel="stylesheet" href="{{ config('voyager.assets_path') }}/css/media/dropzone.css"/>
    <style>
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
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">

                    <div class="panel-heading">
                        <h3 class="panel-title">@if(isset($dataTypeContent->id)){{ 'Edit' }}@else{{ 'Add New' }}@endif {{ $dataType->display_name_singular }}</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form"
                          action="@if(isset($dataTypeContent->id)){{ route($dataType->slug.'.update', $dataTypeContent->id) }}@else{{ route($dataType->slug.'.store') }}@endif"
                          method="POST" enctype="multipart/form-data">
                        <div class="panel-body">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @foreach($dataType->addRows as $row)
                                <div class="form-group">
                                    <label for="name">{{ $row->display_name }} :</label>
                                    @if($row->type == "text")
                                        @if($row->display_name == Config::get('settings.course_name') && $dataType->slug ==  'sections')
                                            <input  type="hidden" class="form-control" name="{{ $row->field }}"
                                                   placeholder="{{ $row->display_name }}" id="course_name"
                                                   {{--pattern="[0-9]*"--}}
                                                   value="@if(isset($dataTypeContent->{$row->field})){{ old($row->field, $dataTypeContent->{$row->field}) }}@else{{old($row->field)}}@endif">
                                            <span id="coursenametyped">
                                               @if(isset($dataTypeContent->id))
                                                    {{$dataTypeContent->courses->name}}
                                                @endif
                                           </span>
                                            <button type="button" class="btn btn-default" id="chooseCourse"><i class="voyager-character"></i>
                                                انتخاب درس
                                            </button>

                                            @include('selectcourse')
                                        @else
                                         <input type="text" class="form-control" name="{{ $row->field }}"
                                               placeholder="{{ $row->display_name }}"
                                               value="@if(isset($dataTypeContent->{$row->field})){{ old($row->field, $dataTypeContent->{$row->field}) }}@else{{old($row->field)}}@endif">
                                        @endif
                                    @elseif($row->type == "password")
                                        @if(isset($dataTypeContent->{$row->field}))
                                            <br>
                                            <small>Leave empty to keep the same</small>
                                        @endif
                                        <input type="password" class="form-control" name="{{ $row->field }}" value="">
                                    @elseif($row->type == "text_area")
                                        <textarea class="form-control"
                                                  name="{{ $row->field }}">@if(isset($dataTypeContent->{$row->field})){{ old($row->field, $dataTypeContent->{$row->field}) }}@else{{old($row->field)}}@endif</textarea>
                                    @elseif($row->type == "rich_text_box")
                                        <textarea class="form-control richTextBox" name="{{ $row->field }}">@if(isset($dataTypeContent->{$row->field})){{ old($row->field, $dataTypeContent->{$row->field}) }}@else{{old($row->field)}}@endif</textarea>
                                    @elseif($row->type == "image" || $row->type == "file")
                                        @if($row->type == "image" && isset($dataTypeContent->{$row->field}))
                                            <img src="{{ Voyager::image( $dataTypeContent->{$row->field} ) }}"
                                                 style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                        @elseif($row->type == "file" && isset($dataTypeContent->{$row->field}))
                                            <div class="fileType">{{ $dataTypeContent->{$row->field} }} }}</div>
                                        @endif
                                        <input type="text" name="{{ $row->field }}" class="Chooser" >{{-- value="@if(isset($dataTypeContent->id)){{$dataTypeContent->{$row->field} }} @endif"--}}
                                            <button type="button" class="btn btn-default" id="choose"><i class="voyager-character"></i>
                                               انتخاب از فایل های سرور
                                            </button>
                                    @elseif($row->type == "select_dropdown")
                                        <?php $options = json_decode($row->details); ?>
                                            @if($row->display_name == Config::get('settings.discount') && $dataType->slug ==  'discount' && $data->{$row->field} == 0)
                                                $options =
                                            @elseif($row->display_name == Config::get('settings.discount') && $dataType->slug ==  'discount' && $data->{$row->field} == 1)
                                                نقدی
                                            @endif
                                        <?php $selected_value = (isset($dataTypeContent->{$row->field}) && !empty(old($row->field,
                                                        $dataTypeContent->{$row->field}))) ? old($row->field,
                                                $dataTypeContent->{$row->field}) : old($row->field); ?>
                                        <select class="form-control" name="{{ $row->field }}">
                                            <?php $default = (isset($options->default) && !isset($dataTypeContent->{$row->field})) ? $options->default : NULL; ?>
                                            @if(isset($options->options))
                                                @foreach($options->options as $key => $option)
                                                    <option value="{{ $key }}" @if($default == $key && $selected_value === NULL){{ 'selected="selected"' }}@endif @if($selected_value == $key){{ 'selected="selected"' }}@endif>{{ $option }}</option>
                                                @endforeach
                                            @endif
                                        </select>

                                    @elseif($row->type == "radio_btn")
                                        <?php $options = json_decode($row->details); ?>
                                        <?php $selected_value = (isset($dataTypeContent->{$row->field}) && !empty(old($row->field,
                                                        $dataTypeContent->{$row->field}))) ? old($row->field,
                                                $dataTypeContent->{$row->field}) : old($row->field); ?>
                                        <?php $default = (isset($options->default) && !isset($dataTypeContent->{$row->field})) ? $options->default : NULL; ?>
                                        <ul class="radio">
                                            @if(isset($options->options))
                                                @foreach($options->options as $key => $option)
                                                    <li>
                                                        <input type="radio" id="option-{{ $key }}"
                                                               name="{{ $row->field }}"
                                                               value="{{ $key }}" @if($default == $key && $selected_value === NULL){{ 'checked' }}@endif @if($selected_value == $key){{ 'checked' }}@endif>
                                                        <label for="option-{{ $key }}">{{ $option }}</label>
                                                        <div class="check"></div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>

                                    @elseif($row->type == "checkbox")

                                        <br>
                                        <?php $options = json_decode($row->details); ?>
                                        <?php $checked = (isset($dataTypeContent->{$row->field}) && old($row->field,
                                                        $dataTypeContent->{$row->field}) == 1) ? true : old($row->field); ?>
                                        @if(isset($options->on) && isset($options->off))
                                            <input type="checkbox" name="{{ $row->field }}" class="toggleswitch"
                                                   data-on="{{ $options->on }}" @if($checked) checked
                                                   @endif data-off="{{ $options->off }}">
                                        @else
                                            <input type="checkbox" name="{{ $row->field }}" class="toggleswitch"
                                                   @if($checked) checked @endif>
                                        @endif

                                    @endif

                                </div>
                            @endforeach
                                {{--packs--}}
                                @if($dataType->slug == "packs")

                                    @if(isset($dataTypeContent->id))
                                        <p hidden id="packId">{{ $dataTypeContent->id }}</p>
                                        <h3>courses</h3>
                                        <div class="modal fade modal-warning" id="add_course_modal">
                                            <div class="modal-dialog">
                                                <div class="modal-content">

                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title"><i class="voyager-character"></i> Add Course</h4>
                                                    </div>

                                                    <div class="modal-body">
                                                        <?php
                                                            $x = array();
                                                            $ids=array();
                                                             foreach ($dataTypeContent->courses as $c){
                                                                 $ids[]=$c->id;
                                                             }
                                                            foreach (App\Course::all() as $item){
                                                                if (! in_array($item->id, $ids)){
                                                                    $x[] = $item;
                                                                }
                                                            }

                                                        ?>
                                                            @if(empty($x))
                                                                تمامی دروس انتخاب شده است
                                                            @else
                                                        <h4>Add new course</h4>

                                                                        <select id="new_courseName" class="form-control">
                                                                            @foreach($x as $item)
                                                                                <option value="{{ $item->id }}">Name: {{ $item->name }}, id: {{ $item->id }}</option>
                                                                                {{--<option >{{ $item }}</option>--}}
                                                                            @endforeach
                                                                        @endif

                                                        </select>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-warning" id="add_course"
                                                                onclick="addc(event)"
                                                                data-link="{{ url('/admin/addCourseInModal') }}"
                                                                data-token="{{ csrf_token() }}">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary" id="addCourse"><i class="voyager-upload"></i>
                                            Add
                                        </button>
                                    <br>
                                        <div class="panel-group" id="accordion" style="margin-left: 15px;margin-right: 15px;">
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" style="float: left;"><span class="caret"></span> </a>course 1
                                                    </h4>
                                                </div>
                                                <div id="collapse1" class="panel-collapse collapse in">
                                                    <div class="panel-body"><p>name</p><p>time</p></div>
                                                    <div class="panel-footer"><input type="button" class="btn btn-primary" value="edit"> <input type="button" class="btn btn-success" value="browse"> </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" style="float: left;"><span class="caret"></span></a>course 2
                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif



                        </div><!-- panel-body -->


                        <!-- PUT Method if we are editing -->
                        @if(isset($dataTypeContent->id))
                            <input type="hidden" name="_method" value="PUT">
                    @endif

                    <!-- CSRF TOKEN -->
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                          enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                               onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </form>

                </div>
            </div>
        </div>
    </div>

    @include('filemodal')

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
        function choosecourse(e) {
            var conceptid = $('#CourseName').find(":selected").val();
            var conceptName = $('#CourseName').find(":selected").text();
            $('#course_name').val(conceptid);
            $('#coursenametyped').text(conceptName);
            console
            toastr.success('selected', "Sweet Success!");
            $('#choose_course_modal').modal('hide');
        }

        function addc(e){
            var conceptName = $('#new_courseName').find(":selected").val();
            var packId = $('#packId').text();
            var t=e.target;
            var url = $(t).attr('data-link');

                //add it to your data
                var data = {
                    _token:$(this).data('token'),
                    conceptName : conceptName,
                    packId : packId
                };
                console.log(packId);
                console.log(url);

                $.ajax({
                    url: url,
                    type:"POST",
                    data: data,
                    success:function(data){
                        // alert(data.msg);
                        if(data.msg==1){
//                            $('#subform').hide('slow');
//                            $('#errorform').show('fast')
                            toastr.error('not possible', "Whoops!");
                        }
                        if(data.msg==2){
                            toastr.error('not possibllllle', "Whoops!");
                        }
                        if(data.msg==3){
                            toastr.success('selected', "Sweet Success!");
                            $('#add_course_modal').modal('hide');
                        }

                    },error:function(){
                        toastr.error('not Connection', "Whoops!");
                    }
                });
        }
        $('#choose').click(function(){
            $('#choose_file_modal').modal('show');
        });
        $('#chooseCourse').click(function(){
            $('#choose_course_modal').modal('show');
        });
//
        $('#addCourse').click(function(){
            $('#add_course_modal').modal('show');
        });
    </script>
@stop
