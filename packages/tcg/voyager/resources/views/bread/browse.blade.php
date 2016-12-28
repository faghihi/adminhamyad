@extends('voyager::master')

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ $dataType->display_name_plural }}
        @if($dataType->slug != 'contacts' && $dataType->slug != 'reviews')
            <a href="{{ route($dataType->slug.'.create') }}" class="btn btn-success">
                افزودن
                <i class="voyager-plus"></i></a>
        @endif

    </h1>
@stop

@section('page_header_actions')

@stop

@section('content')
    <style>
        .modal-header{
            direction: rtl;

        }

    </style>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <table id="dataTable" class="table table-hover">
                            <thead>
                            <tr>
                                @foreach($dataType->browseRows as $rows)
                                    <th>{{ $rows->display_name }}</th>
                                @endforeach
                                <th class="actions">فعالیت ها</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($dataTypeContent as $data)
                                <tr>
                                    @foreach($dataType->browseRows as $row)
                                        <td>

                                            @if($row->type == 'image')
                                                @if(! empty($data->{$row->field}))
                                                <img src="@if( strpos($data->{$row->field}, 'http://') === false && strpos($data->{$row->field}, 'https://') === false ){{ url('storage'.$data->{$row->field} ) }}@else{{ $data->{$row->field} }}@endif" style="width:100px">
                                                @else
                                                    عکسی موجود نمیباشد
                                                @endif
                                            @elseif($row->display_name == Config::get('settings.user'))
                                                {{\App\NormalUser::find($data->{$row->field})->email }}
                                            @elseif($row->display_name == Config::get('settings.course_name'))
                                                {{\App\Course::find($data->{$row->field})->name }}

                                            @elseif($row->display_name == Config::get('settings.discount') && $dataType->slug ==  'discount' && $data->{$row->field} == 0)
                                                درصد
                                            @elseif($row->display_name == Config::get('settings.discount') && $dataType->slug ==  'discount' && $data->{$row->field} == 1)
                                                نقدی

                                            @elseif($row->display_name == Config::get('settings.enable') && $dataType->slug ==  'reviews' && $data->{$row->field} == 0)
                                                تایید نشده
                                            @elseif($row->display_name == Config::get('settings.enable') && $dataType->slug ==  'reviews' && $data->{$row->field} == 1)
                                                تایید شده

                                            @elseif( in_array($row->display_name, Config::get('settings.prices_list')))
                                                @if($data->{$row->field} > 1000)
                                                    <?php $price=$data->{$row->field}/1000 . ' هزار تومان'?>
                                                @else
                                                    <?php $price=$data->{$row->field} . ' تومان'?>
                                                @endif
                                                {{$price}}
                                            @else
                                                {{ $data->{$row->field} }}
                                            @endif
                                        </td>
                                    @endforeach
                                    <td class="no-sort no-click">
                                        @if($dataType->slug == 'providers')
                                            <a href="{{ route('voyager.bread.showall', $data->id) }}" class="btn-sm btn-success pull-right" style="margin-left: 7px">
                                                &nbsp;نمایش کامل&nbsp;<i class="voyager-eye"></i>
                                            </a>
                                        @endif
                                            @if($dataType->slug == 'courses')
                                                <a href="{{ route('voyager.bread.participation', $data->id) }}" class="btn-sm btn-success pull-right" style="margin-left: 7px">
                                                    &nbsp;اسامی شرکت کنندگان&nbsp;<i class="voyager-eye"></i>
                                                </a>
                                            @endif
                                            @if($dataType->slug == 'packs')
                                                <a href="{{ route('voyager.bread.packparticipation', $data->id) }}" class="btn-sm btn-success pull-right" style="margin-left: 7px">
                                                    &nbsp;اسامی شرکت کنندگان&nbsp;<i class="voyager-eye"></i>
                                                </a>
                                            @endif
                                        <div class="btn-sm btn-danger pull-right delete" data-id="{{ $data->id }}" id="delete-{{ $data->id }}">
                                            &nbsp;حذف &nbsp;<i class="voyager-trash"></i>
                                        </div>
                                        <a href="{{ route($dataType->slug.'.edit', $data->id) }}" class="btn-sm btn-primary pull-right edit">
                                            &nbsp;ویرایش&nbsp;<i class="voyager-edit"></i>
                                        </a>
                                        <a href="{{ route($dataType->slug.'.show', $data->id) }}" class="btn-sm btn-warning pull-right">
                                            &nbsp; مشاهده&nbsp;
                                            <i class="voyager-eye"></i>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" style="margin-right: 25px"><i class="voyager-trash"></i> آیا مطمئن هستید که می خواهید
                        این {{ $dataType->display_name_singular }} حذف شود ؟</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route($dataType->slug.'.index') }}" id="delete_form" method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                               value="    حذف " >
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">لغو</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('javascript')
    <!-- DataTables -->
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({ "order": [] });
        });

        $('td').on('click', '.delete', function (e) {
            var form = $('#delete_form')[0];

            form.action = parseActionUrl(form.action, $(this).data('id'));

            $('#delete_modal').modal('show');
        });

        function parseActionUrl(action, id) {
            return action.match(/\/[0-9]+$/)
                    ? action.replace(/([0-9]+$)/, id)
                    : action + '/' + id;
        }
    </script>
@stop