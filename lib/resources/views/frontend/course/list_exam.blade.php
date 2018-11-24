@extends('frontend.master')
@section('title', Request::segment(2) == 'add' ? 'Tạo khóa học' : $course->cou_name)
@section('fb_title','Top khóa học hàng đầu')
@section('fb_description','Nơi cung cấp cho bạn những khóa học tốt nhất, rẻ nhất. Tạo lên một môi trường học tập trên cuộc cách mạng công nghệ 4.0')
@section('fb_image',asset('public/layout/frontend/img/dayne-topkin-60559-unsplash.png'))
@section('main')
    <link rel="stylesheet" type="text/css" href="css/course/detail.css">
    {{--<script type="text/javascript" src="{{asset('public/ckeditor/ckeditor.js')}}"></script>--}}

    <div class="instruction">

        <div class="instruction_body">
            <a href="{{ asset('') }}" class="instruction_item">
                Trang chủ
            </a>
            <a class="instruction_item">
                >
            </a>
            <a href="{{ asset('courses') }}" class="instruction_item">
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
            <a href="{{ asset('course/list_exam/'.$course->id)  }}" class="instruction_item">
                Danh sách bài kiểm tra
            </a>
        </div>

    </div>
    <div class="main_body">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="list_exam"></div>
                    {{--@foreach($exams as $exam)--}}
                        {{--<div class="exam_item">{{ $exam->name }}</div>--}}
                        {{--@foreach($exam->results as $result)--}}
                            {{--<div class="result_item">-- {{ $result->score }} -- {{ $result->created_at }}</div>--}}

                        {{--@endforeach--}}

                    {{--@endforeach--}}
                    @foreach($exams as $exam)
                        <div class="lessonMainItem">
                            <div class="lessonMainPart">
                                <div class="lessonMainPartIcon">
                                    <i class="fas fa-minus"></i>
                                    <i class="fas fa-minus"></i>
                                </div>
                                <div class="lessonMainPartTitle">
                                    {{ $exam->name }}
                                </div>
                                <div class="lessonMainPartTime">
                                    [{{ $exam->time }}p]
                                </div>
                                <div class="">
                                    <a href="{{ asset('courses/detail/'.$course->cou_slug.'.html/exam/'.$exam->id) }}" class="btn btn-warning">
                                        Làm lại
                                    </a>
                                </div>
                            </div>
                            <div class="lessonMainVideo">
                                @foreach($exam->results as $result)
                                    <div  class="lessonMainVideoItem">
                                        <div class="lessonMainVideoIcon">
                                            <i class="fas fa-video"></i>
                                        </div>
                                        <div class="lessonMainVideoTitle">
                                            Hoàn thành : {{ $result->score }}/{{ $result->total_score }} câu

                                        </div>
                                        <div class="lessonMainVideoTitle">

                                            <span>Đạt : {{ number_format(($result->score*100 / $result->total_score),'1','.',',') }}% </span>
{{--{{ $exam->pass }}--}}
                                            @if(($result->score*100 / $result->total_score) >= $exam->pass)
                                            <span class="text-success">PASS</span>
                                            @else
                                            <span class="text-danger">FALSE</span>
                                            @endif
                                        </div>
                                        <div class="lessonMainVideoTime">
                                            {{ $result->updated_at }} |
                                            {{ $result->timeout == null ? 'Xong' : $result->timeout }}
                                            {{--{{ gmdate("i:s", $itemTiny->les_video_duration) }}--}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                    @endforeach
                </div>
            </div>
        </div>
    </div>



@stop

@section('script')
    <script>
        $(document).on('click', '.lessonMainPart' , function(){
            if ($(this).next().is(":hidden")) {
                $(this).find('.lessonMainPartIcon i:first-child').css('transform', 'translateY(-50%) rotate(180deg)');
            }
            else{
                $(this).find('.lessonMainPartIcon i:first-child').css('transform', 'translateY(-50%) rotate(90deg)');
            }
            $(this).next().slideToggle();
        });

    </script>
@stop
