<div class="col-md-6 col-xs-12 ">
    <div class="answerName panel panel-yell ">
        <div class="panel-body answerBody">
            <div class="answerContent">
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" name="correct" {{ $correct == 1 ? 'checked' : ''  }} disabled>
                    </span>
                    <input type="text" class="form-control" name="name" placeholder="Câu trả lời" value="{{ $name }}" disabled>
                </div><!-- /input-group -->
            </div>
            <div class="btnOptionAns">
                <span class="btnEditAns">
                    <i class="fas fa-edit"></i>
                </span>
                <span class="btnEditAns cancel">
                    <i class="fas fa-times-circle"></i>
                </span>
                <span href="{{ asset('teacher/delete_ans/'.$id) }}" class="btnDeleteAns">
                    <i class="fas fa-trash"></i>
                </span>
            </div>
            <form action="{{ asset('teacher/edit_ans/'.$id) }}" method="post" class="formEditAns">
                {{ csrf_field() }}
                <div class="input-group">
                    <span class="input-group-addon">
                        <input type="checkbox" name="correct" {{ $correct == 1 ? 'checked' : '' }}>
                        <input type="text" name="id" value="{{ $id }}" class="d-none">
                    </span>
                    <input type="text" class="form-control" name="name" placeholder="Câu trả lời" value="{{ $name }}" required>
                    <span class="input-group-btn">
                        <button class="btn btn-yell btnSubmitEditAns" type="submit">Sửa</button>
                    </span>
                </div><!-- /input-group -->
            </form>
        </div>

    </div>
</div>