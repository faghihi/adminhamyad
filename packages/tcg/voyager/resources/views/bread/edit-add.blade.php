@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ config('voyager.assets_path') }}/css/media/media.css"/>
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/js/select2/select2.min.css">
    <link rel="stylesheet" href="{{ config('voyager.assets_path') }}/css/media/dropzone.css"/>
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
                                    <label for="name">{{ $row->display_name }}</label>
                                    @if($row->type == "text")
                                        <input type="text" class="form-control" name="{{ $row->field }}"
                                               placeholder="{{ $row->display_name }}"
                                               value="@if(isset($dataTypeContent->{$row->field})){{ old($row->field, $dataTypeContent->{$row->field}) }}@else{{old($row->field)}}@endif">
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
                                        <textarea class="form-control richTextBox"
                                                  name="{{ $row->field }}">@if(isset($dataTypeContent->{$row->field})){{ old($row->field, $dataTypeContent->{$row->field}) }}@else{{old($row->field)}}@endif</textarea>
                                    @elseif($row->type == "image" || $row->type == "file")
                                        @if($row->type == "image" && isset($dataTypeContent->{$row->field}))
                                            <img src="{{ Voyager::image( $dataTypeContent->{$row->field} ) }}"
                                                 style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;">
                                        @elseif($row->type == "file" && isset($dataTypeContent->{$row->field}))
                                            <div class="fileType">{{ $dataTypeContent->{$row->field} }} }}</div>
                                        @endif
                                        <input type="text" name="{{ $row->field }}" class="Chooser">
                                            <button type="button" class="btn btn-default" id="choose"><i class="voyager-character"></i>
                                               انتخاب از فایل های سرور
                                            </button>
                                    @elseif($row->type == "select_dropdown")
                                        <?php $options = json_decode($row->details); ?>
                                            {{--@if($row->display_name == Config::get('settings.discount') && $dataType->slug ==  'discount' && $data->{$row->field} == 0)--}}
                                                {{--$options = --}}
                                            {{--@elseif($row->display_name == Config::get('settings.discount') && $dataType->slug ==  'discount' && $data->{$row->field} == 1)--}}
                                                {{--نقدی--}}
                                            {{--@endif--}}
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
                                                        <h4>New File/Folder Name</h4>
                                                        <select id="new_courseName" class="form-control">
                                                            @foreach(App\Course::all() as $item)
                                                                <option value="{{ $item->id }}">Name: {{ $item->name }}, id: {{ $item->id }}</option>
                                                            @endforeach
                                                    </select>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-warning" id="add_course"
                                                                onclick="addCourse(event)">Add</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary" id="addCourse"><i class="voyager-upload"></i>
                                            Add
                                        </button>
                                    <br>
                                        @foreach($dataTypeContent->courses as $sec)
                                            {{$sec->id}}
                                            {{$sec->name}}
                                            <br>
                                            <!-- Rename File Modal -->
                                        @endforeach
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
    <div class="modal fade modal-warning" id="choose_file_modal">
        <div class="modal-dialog">
            <div class="modal-content">


                <div class="modal-body">
                    <div class="page-content container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="clear"></div>

                                <div id="filemanager">

                                    <div id="uploadPreview" style="display:none;"></div>

                                    <div id="uploadProgress" class="progress active progress-striped">
                                        <div class="progress-bar progress-bar-success" style="width: 0"></div>
                                    </div>

                                    <div id="content">


                                        <div class="breadcrumb-container">
                                            <ol class="breadcrumb filemanager">
                                                <li data-folder="/" data-index="0"><span class="arrow"></span><strong>Media
                                                        Library</strong></li>
                                                <template v-for="folder in folders">
                                                    <li data-folder="@{{folder}}" data-index="@{{ $index+1 }}"><span
                                                                class="arrow"></span>@{{ folder }}</li>
                                                </template>
                                            </ol>

                                            <div class="toggle"><span>Close</span><i class="voyager-double-right"></i></div>
                                        </div>
                                        <div class="flex">

                                            <div id="left">

                                                <ul id="files">

                                                    <li v-for="file in files.items">
                                                        <div class="file_link" data-folder="@{{file.name}}" data-index="@{{ $index }}">
                                                            <div class="link_icon">
                                                                <template v-if="file.type.includes('image')">
                                                                    <div class="img_icon"
                                                                         style="background-size: auto 50px; background: url(@{{ encodeURI(file.path) }}) no-repeat center center;display:inline-block; width:100%; height:100%;"></div>
                                                                </template>
                                                                <template v-if="file.type.includes('video')">
                                                                    <i class="icon voyager-video"></i>
                                                                </template>
                                                                <template v-if="file.type.includes('audio')">
                                                                    <i class="icon voyager-music"></i>
                                                                </template>
                                                                <template v-if="file.type == 'folder'">
                                                                    <i class="icon voyager-folder"></i>
                                                                </template>
                                                                <template
                                                                        v-if="file.type != 'folder' && !file.type.includes('image') && !file.type.includes('video') && !file.type.includes('audio')">
                                                                    <i class="icon voyager-file-text"></i>
                                                                </template>

                                                            </div>
                                                            <div class="details @{{ file.type }}"><h4>@{{ file.name }}</h4>
                                                                <p style="display: none">@{{file.path}}</p>
                                                                <a style="display: none;">@{{ file.type }}</a>
                                                                <small>
                                                                    <template v-if="file.type == 'folder'">
                                                                    <!--span class="num_items">@{{ file.items }} file(s)</span-->
                                                                    </template>
                                                                    <template v-else>
                                                                        <span class="file_size">@{{ file.size }}</span>
                                                                    </template>
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </li>

                                                </ul>

                                                <div id="file_loader">
                                                    <div id="file_loader_inner">
                                                        <div class="icon voyager-helm"></div>
                                                    </div>
                                                    <p>LOADING YOUR MEDIA FILES</p>
                                                </div>

                                                <div id="no_files">
                                                    <h3><i class="voyager-meh"></i> No files in this folder.</h3>
                                                </div>

                                            </div>

                                            <div id="right">
                                                <div class="right_none_selected">
                                                    <i class="voyager-cursor"></i>
                                                    <p>No File or Folder Selected</p>
                                                </div>
                                                <div class="right_details">
                                                    <div class="detail_img @{{ selected_file.type }}">
                                                        <template v-if="selected_file.type.includes('image')">
                                                            <img src="@{{ selected_file.path }}"/>
                                                            @{{selected_file.path}}
                                                        </template>
                                                        <template v-if="selected_file.type.includes('video')">
                                                            <video width="100%" height="auto" controls>
                                                                <source src="@{{selected_file.path}}" type="video/mp4">
                                                                <source src="@{{selected_file.path}}" type="video/ogg">
                                                                <source src="@{{selected_file.path}}" type="video/webm">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </template>
                                                        <template v-if="selected_file.type.includes('audio')">
                                                            <audio controls style="width:100%; margin-top:5px;">
                                                                <source src="@{{selected_file.path}}" type="audio/ogg">
                                                                <source src="@{{selected_file.path}}" type="audio/mpeg">
                                                                Your browser does not support the audio element.
                                                            </audio>
                                                        </template>
                                                        <template v-if="selected_file.type == 'folder'">
                                                            <i class="voyager-folder"></i>
                                                        </template>
                                                        <template
                                                                v-if="selected_file.type != 'folder' && !selected_file.type.includes('audio') && !selected_file.type.includes('video') && !selected_file.type.includes('image')">
                                                            <i class="voyager-file-text-o"></i>
                                                        </template>

                                                    </div>
                                                    <div class="detail_info @{{selected_file.type}}">
							<span><h4>Title:</h4>
							<p>@{{selected_file.name}}</p></span>
                                                        <span><h4>Type:</h4>
							<p>@{{selected_file.type}}</p></span>
                                                        <template v-if="selected_file.type != 'folder'">
								<span><h4>Size:</h4>
								<p><span class="selected_file_count">@{{ selected_file.items }} item(s)</span><span
                                            class="selected_file_size">@{{selected_file.size}}</span></p></span>
                                                            <span><h4>Public URL:</h4>
								<p><a href="{{ URL::to('/') }}@{{ selected_file.path }}" target="_blank">Click Here</a></p></span>
                                                            <span><h4>Last Modified:</h4>
								<p>@{{selected_file.last_modified}}</p></span>
                                                        </template>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="nothingfound">
                                            <div class="nofiles"></div>
                                            <span>No files here.</span>
                                        </div>

                                    </div>
                                </div><!-- #filemanager -->
                                <div id="dropzone"></div>

                            </div><!-- .row -->
                        </div><!-- .col-md-12 -->
                    </div><!-- .page-content container-fluid -->


                    <input type="hidden" id="storage_path" value="{{ storage_path() }}">



                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">لغو</button>
                    <button type="button" class="btn btn-warning" onclick="alerts(event)">انتخاب</button>
                </div>
            </div>
        </div>
    </div>

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
        function addCourse(){

        }
        $('#choose').click(function(){
            $('#choose_file_modal').modal('show');
        });

        $('#addCourse').click(function(){
            $('#add_course_modal').modal('show');
        });


        $("#subscribe").click(function(){
            var url = $(this).attr("data-link");

            //add it to your data
            var data = {
                _token:$(this).data('token'),
                Email:$('#submail').val()
            };
            $.ajax({
                url: url,
                type:"POST",
                data: data,
                success:function(data){
                    // alert(data.msg);
                    if(data.msg==1){
                        $('#subform').hide('slow');
                        $('#errorform').show('fast')
                    }
                    if(data.msg==2){
                        $('#subform').hide('slow');
                        $('#errorform1').show('fast')
                    }
                    if(data.msg==3){
                        $('#subform').hide('slow');
                        $('#successform').show('fast')
                    }

                },error:function(){
                    $('#subform').hide('slow');
                    $('#errorform2').show('fast')
                }
            }); //end of ajax
        });

    </script>
    <!-- Include our script files -->
    <script src="{{ config('voyager.assets_path') }}/js/select2/select2.min.js"></script>
    <script src="{{ config('voyager.assets_path') }}/js/media/dropzone.js"></script>
    <script src="{{ config('voyager.assets_path') }}/js/media/media.js"></script>
@stop
