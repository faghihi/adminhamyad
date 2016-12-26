<div class="modal fade modal-warning" id="add_section_modal">
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
                foreach ($dataTypeContent->section as $s){
                    $ids[]=$s->id;
                }
                foreach (App\Section::all() as $item){
                    if (! in_array($item->id, $ids)){
                        $x[] = $item;
                    }
                }

                ?>
                @if(empty($x))
                    تمامی قسمت های موجود قبلا  انتخاب شده است
                @else
                    <h4>اضافه کردن قسمت</h4>

                    <select id="new_sectionName" class="form-control">
                        @foreach($x as $item)
                            <option value="{{ $item->id }}">Name: {{ $item->name }}, id: {{ $item->id }}</option>
                        @endforeach
                        @endif

                    </select>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">لغو</button>
                <button type="button" class="btn btn-warning" id="add_section"
                        onclick="addsection(event)"
                        data-link="{{ url('/admin/addSectionInModal') }}"
                        data-token="{{ csrf_token() }}">اضافه کردن قسمت</button>
            </div>
        </div>
    </div>
</div>