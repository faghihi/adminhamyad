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