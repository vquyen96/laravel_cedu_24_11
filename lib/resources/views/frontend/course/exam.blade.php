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
            <a href="{{ asset('courses/detail/'.$course->cou_slug.'.html/active')}}" class="instruction_item">
                {{ $course->cou_name }}
            </a>
            <a class="instruction_item">
                >
            </a>
            <a href="{{ asset('teacher/exam/'.$exam->id)  }}" class="instruction_item">
                {{ $exam->name }}
            </a>



        </div>

    </div>
    <div class="timeout center">
        <span>Thời gian còn lại </span><span id="h"></span> : <span id="m"></span> : <span id="s"></span>
    </div>
    <div class="main_body">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="examTitle">
                        <h1>{{ $exam->name }} [{{ $exam->total_score }}đ]</h1>
                    </div>
                </div>
            </div>
            <form method="post" action="{{ asset('courses/exam/'.$result->id) }}">
                {{ csrf_field() }}
            @foreach($ques as $que)

                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-blue">
                                <div class="quesName panel-heading">
                                <span class="quesNameContent panel-title">
                                    {{ $que->order }}. {{ $que->name }} [{{ $que->score }}đ]
                                </span>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        @foreach($que->answer as $answer)
                                            <div class="col-md-6 col-xs-12 ">
                                                <div class="answerName panel panel-yell ">
                                                    <div class="panel-body answerBody">
                                                        <div class="answerContent">

                                                            <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <input type="checkbox" name="correct[{{$que->id}}_{{ $answer->id }}]"}}>
                                                            </span>
                                                                <input class="form-control" placeholder="Câu trả lời" value="{{ $answer->name }}" disabled>
                                                            </div><!-- /input-group -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




            @endforeach
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <input type="submit" class="btn btn-outline-primary" value="Gửi">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>



@stop

@section('script')
    <script type="text/javascript" src="js/teacher/exam.js"></script>
    <script language="javascript">
        $(document).ready(function (){
            var url = $('.currentUrl').text();
            if (confirm('Bạn muốn bắt đầu làm bài "{{ $exam->name }}"')){
                var h = {{$time_out[0]}}; // Giờ
                var m = {{$time_out[1]}}; // Phút
                var s = {{$time_out[2]}}; // giây

                // var h = 0; // Giờ
                // var m = 0; // Phút
                // var s = 3; // giây

                var timeout = null; // Timeout
                start();
                function start()
                {
                    if (s === -1){
                        m -= 1;
                        s = 59;
                    }
                    if (m === -1){
                        h -= 1;
                        m = 59;
                    }
                    if (h === -1){
                        $('form').submit();
                        clearTimeout(timeout);
                        return false;
                    }
                    $('#h').html(h);
                    $('#m').html(m);
                    $('#s').html(s);
                    // console.log(h+':'+m+':'+s);

                    timeout = setTimeout(function(){
                        s--;
                        start();
                    }, 1000);
                };
                setInterval(function () {
                    check_status();
                },5000);

            }
            else{
                window.history.back();
            }
        });



        function check_status() {
            var timeout = $('#h').html()+'-'+$('#m').html()+'-'+$('#s').html();
            console.log(timeout);
            console.log(timeout);
            console.log(timeout);
            $.ajax({
                method: 'POST',
                url: url+'courses/exam/updatetimeout',
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'id': '{{ $exam->id }}',
                    'timeout' : timeout,
                    'acc_id' : '{{ Auth::user()->id }}'
                },
                success: function (resp) {
                    console.log(resp);
                    // console.log(timeout);
                },
                error: function (resp) {

                }
            });
        }
        // function timeover(id){
        //     $.ajax({
        //         method: 'POST',
        //         url: url+'cart/update_status',
        //         data: {
        //             '_token': $('meta[name="csrf-token"]').attr('content'),
        //             'id': id,
        //             'status': '-1'
        //         },
        //         success: function (resp) {
        //             if(resp){
        //                 window.location.href = url+'complete?status=-1';
        //             }
        //         },
        //         error: function (resp) {
        //             console.log(resp);
        //         }
        //     });
        // }

        tagScroll();
        function tagScroll(){
            var timeTag = $('.timeout').offset().top;
            // var footer = $('footer').offset().top;
            // console.log(courseTag);
            $( document ).scroll(function(){
                var top = $(document).scrollTop();
                // console.log(top);
                if (top > timeTag) {
                    $('.timeout').css({'position':'fixed', 'top': '0', 'left': '0', 'width': '100%', 'z-index': '3'});
                }
                else{
                    $('.timeout').css({'position':'unset'});
                }

                // console.log($(document).scrollTop());
            });
        }
    </script>
@stop
