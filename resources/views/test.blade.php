@extends('voyager::master')
@section('css')
    <link rel="stylesheet" href="{{ config('voyager.assets_path') }}/css/media/media.css"/>
    <link rel="stylesheet" type="text/css" href="{{ config('voyager.assets_path') }}/js/select2/select2.min.css">
    <link rel="stylesheet" href="{{ config('voyager.assets_path') }}/css/media/dropzone.css"/>
@stop

@section('content')
    <button type="button" class="btn btn-default" id="choose"><i class="voyager-character"></i>
        Rename
    </button>
    @include('filemodal')




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
        //
        $('#addCourse').click(function(){
            $('#add_course_modal').modal('show');
        });
    </script>
    <script type="text/javascript">
        var media = new VoyagerMedia({
            baseUrl: "{{ route('voyager.dashboard') }}"
        });
        $(function () {
            media.init();
        });
        function alerts() {
            var model=$('.selected .details a').text()
            if(model=='folder')
                alert('not possible');
            else
                alert($('.selected .details p').text());
//            alert('salam');
        }
        $('#choose').click(function(){
//            if(typeof(manager.selected_file) !== 'undefined'){
//                $('#rename_file').val(manager.selected_file.name);
//            }
            $('#choose_file_modal').modal('show');
        });
    </script>
@stop