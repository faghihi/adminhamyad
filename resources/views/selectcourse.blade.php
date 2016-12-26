<div class="modal fade modal-warning" id="choose_course_modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="voyager-character"></i> انتخاب درس</h4>
            </div>

            <div class="modal-body">
                    <select id="CourseName" class="form-control">
                        @foreach(App\Course::all() as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach

                    </select>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">لغو</button>
                <button type="button" class="btn btn-warning" id="add_section"
                        onclick="choosecourse(event)" >انتخاب درس</button>
            </div>
        </div>
    </div>
</div>