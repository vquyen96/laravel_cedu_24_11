@extends('frontend.master')
@section('title', Request::segment(2) == 'add' ? 'Tạo khóa học' : $course->cou_name)
@section('fb_title','Top khóa học hàng đầu')
@section('fb_description','Nơi cung cấp cho bạn những khóa học tốt nhất, rẻ nhất. Tạo lên một môi trường học tập trên cuộc cách mạng công nghệ 4.0')
@section('fb_image',asset('public/layout/frontend/img/dayne-topkin-60559-unsplash.png'))
@section('main')
    <link rel="stylesheet" type="text/css" href="css/teacher/exam.css">
    <script type="text/javascript" src="{{asset('public/ckeditor/ckeditor.js')}}"></script>

    <div class="instruction">

        <div class="instruction_body">
            <a href="{{ asset('') }}" class="instruction_item">
                Trang chủ
            </a>
            <a class="instruction_item">
                >
            </a>
            <a href="{{ asset('teacher/courses') }}" class="instruction_item">
                Khóa học
            </a>
            <a class="instruction_item">
                >
            </a>
            <a href="{{ Request::segment(2) == 'add' ? asset('teacher/add') : asset('teacher/courses/'.$course->cou_slug)}}" class="instruction_item">
                {{ Request::segment(2) == 'add' ? 'Thêm mới' : $course->cou_name }}
            </a>
            <a class="instruction_item">
                >
            </a>
            <a href="{{ asset('teacher/exam/'.$exam->id)  }}" class="instruction_item">
                {{ $exam->name }}
            </a>



        </div>

    </div>
    <div class="main_body">
        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <div class="exam_head">
                        <ul class="nav nav-tabs">
                            <li role="presentation" class="active"><a >Thông tin</a></li>
                            <li role="presentation"><a>Thêm câu hỏi</a></li>
                            <li role="presentation"><a>Danh sách câu hỏi</a></li>
                        </ul>
                    </div>
                    {{--<div class="examTitle">--}}
                        {{--<h1>{{ $exam->name }} [{{ $exam->total_score }}]</h1>--}}
                    {{--</div>--}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mainBig">
                        <div class="mainItem">
                            <form action="{{asset('teacher/edit_exam/'.$exam->id)}}" method="post" class="form_edit_exam">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Tên bài thi</label>
                                    <input type="text" name="name" class="form-control" value="{{ $exam->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Chi tiết bài thi</label>
                                    <textarea name="description" class="form-control" rows="5">{!! $exam->description !!}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Thời gian làm bài</label>
                                            <input type="number" name="time" class="form-control" value="{{ $exam->time }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label>Tỷ lệ vượt qua</label>
                                            <input type="number" name="pass" class="form-control" value="{{ $exam->pass }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-yell text-center" value="Cập nhật">
                                </div>
                            </form>
                        </div>
                        <div class="mainItem">
                            <div class="row">
                                <div class="col-md-12">
                                    {{--<h2>Thêm câu hỏi</h2>--}}
                                    <form action="{{ asset('teacher/add_allquestion/'.$exam->id) }} " method="post" class="form_add_ques">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <textarea name="que[name]"  class="form-control" rows="10" placeholder="Câu hỏi "></textarea>
                                            {{--<input type="text" name="name" class="form-control" placeholder="Câu hỏi ">--}}
                                        </div>
                                        <div class="form-group">
                                            <label>Số điểm</label>
                                            <input type="number" name="que[score]" class="" >
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="text-center mb-3">
                                                    <label >Câu trả lời</label>
                                                </div>

                                            </div>
                                            @for( $i = 0; $i < 4 ; $i++)
                                            <div class="col-md-6">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-addon">
                                                        <input type="checkbox" name="ans[correct_{{ $i }}]">
                                                    </span>
                                                    <input type="text" class="form-control" name="ans[name_{{ $i }}]" placeholder="Câu trả lời">
                                                </div><!-- /input-group -->
                                            </div>
                                            @endfor

                                        </div>
                                        <div class="form-group text-right">
                                            <button type="button" class="btn btn-success btn_add_ans">Thêm câu trả lời</button>
                                            <input type="submit" name="" class="btn btn-yell" value="Tạo mới" >
                                        </div>
                                        {{--<div class="row">--}}
                                            {{--<div class="col-md-1">--}}

                                            {{--</div>--}}
                                            {{--<div class="col-md-6">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<textarea name="name"  cols="30" rows="10" placeholder="Câu hỏi "></textarea>--}}
                                                    {{--<input type="text" name="name" class="form-control" placeholder="Câu hỏi ">--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-2">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<input type="number" name="score" class="form-control" placeholder="Điểm ">--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-2">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<input type="number" name="num_ans" class="form-control" placeholder="Số đáp án  ">--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="col-md-1">--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<button class="btn btn-yell form-control" type="submit">Thêm</button>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="mainItem">
                            <ul class="list_ques">
                                @foreach($ques as $que)
                                    <li>
                                        <div class="row que_item">
                                            <div class="col-md-12">
                                                <div class="panel panel-default" >
                                                    <div class="quesName panel-heading">
                                                        <span class="quesNameContent panel-title">
                                                            <span class="handle">
                                                              <i class="fa fa-ellipsis-v"></i>
                                                              <i class="fa fa-ellipsis-v"></i>
                                                            </span>
                                                            <input type="number" min="1" required value="{{$loop->index + 1}}" name="order">
                                                            <input type="text" class="d-none" value="{{ $que->id }}">
                                                            <span class="quesNameContentMain">
                                                                {{ $que->name }} __ [{{ $que->score }}]
                                                            </span>

                                                        </span>
                                                        <div class="btnOptionQues">
                                                            <span class="btnEditQues">
                                                                <i class="fas fa-edit"></i>
                                                            </span>
                                                            <span class="btnEditQues cancle" id="cancelEditQues">
                                                                <i class="fas fa-times-circle"></i>
                                                            </span>
                                                            <span href="{{ asset('teacher/delete_question/'.$que->id) }}"
                                                               class="btnDeleteQues">
                                                                <i class="fas fa-trash"></i>
                                                            </span>
                                                        </div>

                                                        <form action="{{ asset('teacher/edit_question/'.$que->id) }} " method="post" class="formEditQues">
                                                            {{ csrf_field() }}
                                                            <div class="row d-flex align-items-center">
                                                                <div class="col-md-1">
                                                                    <div class="">
                                                                        <span class="handle">
                                                                            <i class="fa fa-ellipsis-v"></i>
                                                                            <i class="fa fa-ellipsis-v"></i>
                                                                        </span>
                                                                        <input type="text" name="id" class="form-control d-none" placeholder="id " value="{{ $que->id }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="">
                                                                        <input type="text" name="name" class="form-control" placeholder="Câu hỏi " value="{{ $que->name }}">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="">
                                                                        <input type="number" name="score" class="form-control" placeholder="Điểm " value="{{ $que->score }}" min="0">
                                                                    </div>
                                                                </div>
                                                                {{--<div class="col-md-2">--}}
                                                                    {{--<div class="">--}}
                                                                        {{--<input type="number" name="num_ans" class="form-control" placeholder="Số đáp án  " value="{{ $que->num_ans }}">--}}
                                                                    {{--</div>--}}
                                                                {{--</div>--}}
                                                                <div class="col-md-1">
                                                                    <div class="">
                                                                        <input class=" form-control btn btn-block btn-yell btnSubmitEditQues" type="submit" value="Sửa">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </form>
                                                        <div class="btnShowAns" id_quess="{{ $que->id }}">
                                                            <i class="fas fa-caret-left"></i>
                                                        </div>
                                                    </div>
                                                    <div class="panel-body list_ans">
                                                        <div class="row">
                                                            @foreach($que->answer as $answer)
                                                                <div class="col-md-6 col-xs-12 ">
                                                                    <div class="answerName panel panel-yell ">
                                                                        <div class="panel-body answerBody">
                                                                            <div class="answerContent">

                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <input type="checkbox" name="correct" {{ $answer->correct == 1 ? 'checked' : ''  }} disabled>
                                                                                    </span>
                                                                                    <input type="text" class="form-control" name="name" placeholder="Câu trả lời" value="{{ $answer->name }}" disabled>
                                                                                </div><!-- /input-group -->
                                                                            </div>
                                                                            <div class="btnOptionAns">
                                                                                <span class="btnEditAns">
                                                                                    <i class="fas fa-edit"></i>
                                                                                </span>
                                                                                <span class="btnEditAns cancel">
                                                                                    <i class="fas fa-times-circle"></i>
                                                                                </span>

                                                                                <span href="{{ asset('teacher/delete_ans/'.$answer->id) }}" class="btnDeleteAns" >
                                                                                    <i class="fas fa-trash"></i>
                                                                                </span>
                                                                            </div>

                                                                            <form action="{{ asset('teacher/edit_ans/'.$answer->id) }}" method="post" class="formEditAns">
                                                                                {{ csrf_field() }}
                                                                                <div class="input-group">
                                                                                    <span class="input-group-addon">
                                                                                        <input type="checkbox" name="correct" {{ $answer->correct == 1 ? 'checked' : '' }}>
                                                                                        <input type="text" name="id" value="{{ $answer->id }}" class="d-none">
                                                                                    </span>
                                                                                    <input type="text" class="form-control" name="name" placeholder="Câu trả lời" value="{{ $answer->name }}" required>
                                                                                    <span class="input-group-btn">
                                                                                        <button class="btn btn-yell btnSubmitEditAns" type="submit">Sửa</button>
                                                                                    </span>
                                                                                </div><!-- /input-group -->
                                                                            </form>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                            <div class="col-md-6 col-xs-12">
                                                                <form action="{{ asset('teacher/add_ans/'.$que->id) }}" method="post" class="form_add_ans">
                                                                    {{ csrf_field() }}
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon">
                                                                            <input type="checkbox" name="correct">
                                                                        </span>
                                                                        <input type="text" class="form-control" name="name" placeholder="Câu trả lời">
                                                                        <span class="input-group-btn">
                                                                        <button class="btn btn-blue" type="submit">Thêm</button>
                                                                        </span>
                                                                    </div><!-- /input-group -->
                                                                </form>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </li>


                                @endforeach
                            </ul>
                            <div class="text-right">
                                <span class="icon_load">
                                    <img src="img/Double Ring-1.4s-200px.gif">
                                </span>
                                <button class="btn btn-blue btnSort">
                                    Sắp xếp lại
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>



@stop

@section('script')
    <script type="text/javascript" src="js/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="js/jquery/jquery.validate.js"></script>

    <script type="text/javascript" src="js/teacher/exam.js"></script>

@stop