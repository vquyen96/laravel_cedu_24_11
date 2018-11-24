@extends('frontend.master')
@section('title', Request::segment(2) == 'add' ? 'Tạo khóa học' : $course->cou_name)
@section('fb_title','Top khóa học hàng đầu')
@section('fb_description','Nơi cung cấp cho bạn những khóa học tốt nhất, rẻ nhất. Tạo lên một môi trường học tập trên cuộc cách mạng công nghệ 4.0')
@section('fb_image',asset('public/layout/frontend/img/dayne-topkin-60559-unsplash.png'))
@section('main')
    <link rel="stylesheet" type="text/css" href="css/teacher/exam.css">
    {{--<script type="text/javascript" src="{{asset('public/ckeditor/ckeditor.js')}}"></script>--}}

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
            <a href="{{ asset('courses/detail/'.$course->cou_slug.'.html')}}" class="instruction_item">
                {{ $course->cou_name }}
            </a>
            <a class="instruction_item">
                >
            </a>
            <a href="{{ asset('courses/list_exam/'.$course->cou_id)  }}" class="instruction_item">
                Danh sách bài kiểm tra
            </a>
        </div>

    </div>
    <div class="main_body">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="result">

                        <div class="panel panel-blue">
                            <div class="quesName panel-heading">
                                <span class="quesNameContent panel-title">
                                    {{ $exam->name }}
                                </span>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped result_table">
                                    <tr>
                                        <td>Tên học sinh: </td>
                                        <td>{{ \Illuminate\Support\Facades\Auth::user()->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Môn học: </td>
                                        <td>{{ $course->cou_name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bài kiểm tra: </td>
                                        <td>{{ $exam->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tổng điểm: </td>
                                        <td>{{ $total_score }}</td>
                                    </tr>
                                    <tr>
                                        <td>Điểm số: </td>
                                        <td>{{ $score }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tỷ lệ: </td>
                                        <td>{{ ($score/$total_score)*100 }}%</td>
                                    </tr>
                                    <tr>
                                        <td>Qua Bài: </td>
                                        <td>{{ ($score/$total_score) >= $exam->pass ? 'PASS' : 'NOPASS' }}</td>
                                    </tr>

                                </table>
                                <div class="gr_btn" style="text-align: center">

                                    <a href="{{ asset('courses/detail/'.$course->cou_slug.'.html/exam/'.$exam->id) }}" class="btn btn-blue">Làm lại</a>
                                    @if($score/$total_score >= \App\Models\Exam::PASS)

                                        @if($next_exam != null)
                                            <a href="{{ asset('courses/detail/'.$course->cou_slug.'.html/exam/'.$next_exam->id) }}" class="btn btn-warning">Bài kế tiếp</a>
                                        @else
                                                <a href="{{ asset('courses/exam_done/'.$course->cou_slug.'.html') }}" class="btn btn-warning">Hoàn thành</a>
                                        @endif

                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



@stop

@section('script')
    {{--<script type="text/javascript" src="js/teacher/exam.js"></script>--}}
@stop
