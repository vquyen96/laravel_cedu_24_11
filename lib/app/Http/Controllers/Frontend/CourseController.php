<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\OrderDetail;
use App\Models\Question;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Group;
use App\Models\Account;
use App\Models\Code;
use App\Models\Rating;
use App\Models\Teacher;
use App\Models\Doc;
use \App\Models\Leaning;
use \App\Models\Aff;
use \Illuminate\Support\Facades\Auth;
use View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class CourseController extends Controller
{
    public function getList(Request $request){
        return redirect('search');
        if (($request->price != null && $request->price != "null") || ($request->level != null && $request->level != "null") || ($request->tag != null && $request->tag != "null")) {
            if($request->price != null && $request->price != "null"){
                $price = (int)$request->price;
            }
            else{
                $price = 10000000;
            }
            if($request->tag != null && $request->tag != "null"){
                $tag = $request->tag;
            }
            else{
                
                $tag = "";
            }
            if($request->level != null && $request->level != "null"){
                $level = $request->level;
            }
            else{
                
                $level = "all";
            }
            $data['course'] = Course::where('cou_status', '1')->get();
            $data['courseByMost'] = Course::where('cou_price','<', $price)->where('cou_tag', 'like', '%'.$tag.'%')->where('cou_level', $level)->orderBy('cou_student','desc')->where('cou_status', '1')->paginate(6);
            $data['courseNewMost'] = Course::where('cou_price','<', $price)->where('cou_tag', 'like', '%'.$tag.'%')->where('cou_level', $level)->orderBy('created_at','desc')->where('cou_status', '1')->paginate(6);
            $data['courseVoteMost'] = Course::where('cou_price','<', $price)->where('cou_tag', 'like', '%'.$tag.'%')->where('cou_level', $level)->orderBy('cou_star','desc')->where('cou_status', '1')->paginate(6);
            $data['courseSaleMost'] = Course::where('cou_price','<', $price)->where('cou_tag', 'like', '%'.$tag.'%')->where('cou_level', $level)->orderBy('cou_sale','desc')->where('cou_status', '1')->paginate(6);

            $data['teacher'] = Teacher::orderBy('tea_featured','desc')->paginate(7);
            $data['teacher_total'] = Teacher::count();
            
            // dd($data['teacher']);
            return view('frontend/course',$data);
        }
        $data['course'] = Course::where('cou_status', '1')->get();
    	$data['courseByMost'] = Course::orderBy('cou_student','desc')->where('cou_status', '1')->paginate(15);
        $data['courseNewMost'] = Course::orderBy('created_at','desc')->where('cou_status', '1')->paginate(15);
        $data['courseVoteMost'] = Course::orderBy('cou_star','desc')->where('cou_status', '1')->paginate(15);
        $data['courseSaleMost'] = Course::orderBy('cou_sale','desc')->where('cou_status', '1')->paginate(15);

    	$data['teacher'] = Teacher::orderBy('tea_featured','desc')->paginate(7);
        $data['teacher_total'] = Teacher::count();
        
    	return view('frontend/course',$data);
    }
    public function getDetail($slug){
        if (Auth::check() && Auth::user()->level == 8) {
            return redirect('aff/share/'.$slug);
        }
    	$cou = Course::where('cou_slug',$slug)->first();
        if ($cou == null) {
            return redirect('teacher/courses');
        }
        // dd($cou);
        $gr_child = [];
        if ($cou->group->gr_parent_id == 0) {
            $cou->cou_gr_child_id = null;
            $cou->cou_gr_name = $cou->group->gr_name;
        }
        else{
            $cou->cou_gr_child_id = $cou->cou_gr_id;
            $cou->cou_gr_child_name = Group::find($cou->cou_gr_child_id)->gr_name;

            $cou->cou_gr_id = $cou->group->gr_parent_id;
            $cou->cou_gr_name = Group::find($cou->cou_gr_id)->gr_name;
            $gr_child = Group::where('gr_parent_id', $cou->group->gr_parent_id)->get();
        }
        $list_gr_child = Group::where('gr_parent_id', $cou->cou_gr_id )->get(['gr_id'])->toArray();
        $list_gr_child = array_column(json_decode(json_encode($list_gr_child),true),'gr_id');
        $list_gr_child = array_merge($list_gr_child,[$cou->cou_gr_id]);
        
        // $group = Group::find($cou->cou_gr_id);
        
        // $course_relate = $group->course;
        
        // $list_cou_ids = [];
        // foreach ($course_relate as $item) {
        //     if ($cou->cou_id != $item->cou_id) {
        //         $list_cou_ids[] = $item->cou_id;
        //     }
        // }

        $data['course_relate'] = Course::whereIn('cou_gr_id', $list_gr_child)->inRandomOrder()->take(3)->get();

        // dd($data['course_relate']);
        $data['course'] = $cou;
        if ($data['course']->group->gr_parent_id != 0) {
            $data['course']->group = Group::find($data['course']->group->gr_parent_id);
        }
        if ($cou->cou_status == 1) {
            if(Auth::check()){
                $data['acc'] = Account::where('id', Auth::user()->id)->where('level', 8)->first();
                $orderDe_id = 0;
                $code = 0;
                foreach ($cou->orderDe as $item) {
                    if ($item->order != null && $item->order->ord_acc_id == Auth::user()->id && $item->order->ord_status == 0) {
                        $orderDe_id = $item->orderDe_id;
                    }
                }
                if ($orderDe_id != null) {
                    $code = Code::where('code_orderDe_id',$orderDe_id)->first();
                }
                
                if($code != null){
                    if($code->code_status == 1){
                        return redirect('courses/detail/'.$slug.'.html/active');
                    }
                    else{
                        return view('frontend.course.detail',$data)->with('error','Bạn chưa kích hoạt khóa học này');
                    }
                }
                else{
                    return view('frontend.course.detail',$data);
                }
            }
            else{
                return view('frontend.course.detail',$data);
            }
        }
        else{
            return back()->with('error','Khóa học của chúng tôi đang trong quá trình bảo trì');
        }
            
    	
    }
    public function getGroup($slug){
    	$group = Group::where('gr_slug', $slug)->first();
    	$groupId = $group->gr_id;
        if ($group->gr_parent_id == 0) {
            $list_gr = Group::where('gr_parent_id', $groupId)->get(['gr_id'])->toArray();
            $list_gr[] = $groupId;
            // $list_gr = array_column(json_decode(json_encode($list_gr),true),'gr_id');
        }
        else{
            $list_gr = [$groupId];
        }

    	$data['group'] = $group;
        $data['group_child'] = Group::where('gr_parent_id', $group->gr_id)->get();
    	$course = Course::whereIn('cou_gr_id',$list_gr)->where('cou_status', '1');

        $data['courseByMost'] = Course::whereIn('cou_gr_id',$list_gr)->where('cou_status', '1')->orderBy('cou_student','desc')->take(10)->get();
        $data['courseNewMost'] = Course::whereIn('cou_gr_id',$list_gr)->where('cou_status', '1')->orderBy('created_at','desc')->take(10)->get();
        $data['courseVoteMost'] = Course::whereIn('cou_gr_id',$list_gr)->where('cou_status', '1')->orderBy('cou_star','desc')->take(10)->get();
        // dd($data['courseVoteMost']);
        $data['courseSaleMost'] = $course->orderBy('cou_sale','desc')->take(10)->get();
    	$data['teacher'] = Teacher::orderBy('tea_featured','desc')->paginate(10);
        // $data['teacher_total'] = Teacher::count();
        // dd($data['courseVoteMost']);
    	return view('frontend.course.group',$data);
    }
    public function getAll(Request $request, $slug){

        $group = Group::where('gr_slug', $slug)->first();
        $groupId = $group->gr_id;
        if ($group->gr_parent_id == 0) {
            $list_gr = Group::where('gr_parent_id', $groupId)->get(['gr_id'])->toArray();
            $list_gr[] = $groupId;
            // $list_gr = array_column(json_decode(json_encode($list_gr),true),'gr_id');
        }
        else{
            $list_gr = [$groupId];
        }


        $course = Course::where('cou_status', 1)->whereIn('cou_gr_id',$list_gr);
        // dd($course->get());
        $paramater = $request->all();
        // dd($paramater);
        // $group = isset($request->group) ? $request->group : [];
        $gr_child = isset($request->gr_child) ? $request->gr_child : [];
        $price = isset($request->price) ? $request->price : [];
        $level = isset($request->level) ? $request->level : [];
        $type = isset($request->type) ? $request->type : [];
        // dd($request->all());
        

        if (count($gr_child)) {
            $course = $course->whereIn('cou_gr_id', $gr_child);
        }
        if (count($price)) {
            if (in_array(1, $price)) {
                $course = $course->orderBy('cou_price', 'asc');
            }
            else {
                $course = $course->orderByDesc('cou_price');
            }
            
        }
        if (count($level)) {
            $course = $course->whereIn('cou_level', $level);
        }

        switch ($request->course) {
            case '1':
                $course = $course->orderByDesc('updated_at');
                break;
            case '2':
                $course = $course->orderByDesc('cou_student');
                break;
            case '3':
                $course = $course->orderByDesc('cou_star');
                break;
            
            default:
                # code...
                break;
        }

        if (!$paramater) {
            $paramater = [
                'course' => '1',
                'group' => [],
                'gr_child' => [],
                'price' => [],
                'level' => [],
                'type' => []
            ];
        }
        $data['paramater'] = $paramater;
        $data['group'] = $group;
        $data['group_child'] = Group::where('gr_parent_id', $group->gr_id)->get();
        $data['courses'] = $course->paginate(10);
        
        $data['teacher'] = Teacher::orderBy('tea_featured','desc')->paginate(10);
        // dd($data);
        return view('frontend.course.all',$data);
    }
    public function getVideo($slug, $id){

        $data['course'] = Course::where('cou_slug',$slug)->first();

        if ($data['course']->group->gr_parent_id != 0) {
            $data['course']->group = Group::find($data['course']->group->gr_parent_id);
        }
        $user = Auth::user();
        if(Auth::check()){
            $acc = Account::where('id',Auth::user()->id)->first();
            $orderDe_id = null;
            foreach ($data['course']->orderDe as $item) {
                if ($item->order->ord_acc_id == $user->id) {
                    $orderDe_id = $item->orderDe_id;
                }
            }
            
            $code = Code::where('code_orderDe_id',$orderDe_id)->first();
            if($code != null){
                if($code->code_status == 1){
                    $docs = Doc::where('doc_cou_id', $data['course']->cou_id)->get();
                    // $data['course'] = Course::where('cou_slug',$slug)->first();
                    // dd($data['course']);
                    $data['part'] = $data['course']->part;
                    $index_video = 0;
                    $data['listVideo'] = [];
                    foreach ($data['part'] as $part) {
                        // dd($part->lesson);
                        foreach ($part->lesson as $lesson) {
                            foreach ($docs as $doc) {
                                // dd($lesson);
                                if ($doc->doc_les_id == $lesson->les_id) {
                                    // dd($doc);
                                    $lesson->les_doc_link = $doc->doc_link;
                                }
                            }
                            $check = DB::table('leaning')->where('account_id',$user->id)->where('lesson_id',$lesson->les_id)->first();
                            if($check) $lesson->check = $check->status;
                            else $lesson->check = 0;
                            $data['listVideo'][$index_video] = $lesson;
                            $index_video++;
                        }
                        // dd($part->lesson);
                    }
                    // dd($data['listVideo']);
                    if ($id < 0 || $id >= count($data['listVideo'])) {

//                        dd($this->checkLearnDone($acc, $data['course']));
                        if($id == (count($data['listVideo']))){
                            if ($this->checkLearnDone($acc, $data['course']) > 0.8){
                                return redirect('courses/detail/'.$slug.'.html/exam/'.$data['course']->exam[0]->id);
                            }
                        }
                        return redirect('/')->with('error', 'Bài học không tồn tại');
                    }
                    else{

                        $data['video'] = $data['listVideo'][$id];
                        $data['video']->les_link = asset('video/'.$data['video']->les_link);
//                        $data['video']->les_link = asset('video/'.str_replace(".mp4","",$data['video']->les_link));
                    }

                    $leaning = DB::table('leaning')->where('account_id',$user->id)->where('lesson_id',$data['listVideo'][$id]->les_id)->first();

                    $data['leaning'] = $leaning;

                    $data['doc'] = $docs;
                    return view('frontend.course.video',$data);
                }
                else{
                    return redirect('courses/detail/'.$slug.'.html')->with('error','Bạn chưa kích hoạt khóa học này');
                }
            }
            else{
                return redirect('courses/detail/'.$slug.'.html');
            }
        }
        else{
            return redirect('courses/detail/'.$slug.'.html');
        }

                    
    }

    function checkLearnDone(Account $acc, Course $cou){
        $list_vid = [];
        foreach ($cou->part as $part){
            foreach ($part->lesson as $les){
                $list_vid[] = $les->les_id;
            }
        }
        $total_learn = Leaning::where('account_id', $acc->id)->whereIn('lesson_id', $list_vid)->get()->count();
        if ($total_learn == 0){
            return 1;
        }
        $learn_done = Leaning::where('account_id', $acc->id)->whereIn('lesson_id', $list_vid)->where('status', 2)->get()->count();
        return $learn_done/$total_learn;
    }

    function update_time_les(Request $request){
        $req = $request->all();
        $user = Auth::user();

        $lesson = DB::table('lesson')->where('les_id',$req['les_id'])->first();

        if($lesson){
            $leaning = DB::table('leaning')->where('account_id',$user->id)->where('lesson_id',$req['les_id'])->first();
            if($leaning){
//                dd($req['current_time'].'--'.$lesson->les_video_duration-5);
//                return response($lesson->les_video_duration-5, 200);
                $status = $leaning->status;
                if($req['current_time'] >= ($lesson->les_video_duration-5) && $status == 1) $status = 2;

//                dd(DB::table('leaning')->where('account_id',$user->id)->where('lesson_id',$req['les_id'])->update(['updated_at' => time(),'time_in_video' => $req['current_time'],'status' => $status]));
                DB::table('leaning')->where('account_id',$user->id)->where('lesson_id',$req['les_id'])->update(['updated_at' => time(),'time_in_video' => $req['current_time'],'status' => $status]);
            }else {
                if($req['current_time'] >= $lesson->les_video_duration-5) $status = 2;
                else $status = 1;
                $data = [
                    'account_id' => $user->id,
                    'lesson_id' => $req['les_id'],
                    'created_at' => time(),
                    'updated_at' => time(),
                    'time_in_video' => $req['current_time'],
                    'status' => $status
                ];
                Leaning::create($data);
            }
        }

        return json_encode([
            'status' => 1
        ]);
    }
    public function getLearning(){
        $les_id = (int)Input::get('les_id');
        $acc_id = (int)Input::get('acc_id');
        $leaning = Leaning::where('account_id', $acc_id)->where('lesson_id', $les_id)->first();
        return response( $leaning, 200);
    }
    public function getTeacher($slug){
        $course = Course::where('cou_slug',$slug)->first();
        $data['teacher'] = $course->tea;
        return view('frontend.teacher',$data);
    }

    //Vào trang chi tiết khi đã đăng ký học
    public function getActive($slug){
        // Check đăng nhập
        if(Auth::check()){

            $cou = Course::where('cou_slug',$slug)->first();
            // Check khóa học đang hoạt động
            if ($cou != null && $cou->cou_status == 1) {
                foreach ($cou->orderDe as $item) {
                    if ($item->order->ord_acc_id == Auth::user()->id) {
                        $orderDe_id = $item->orderDe_id;
                    }
                }
                $code = Code::where('code_orderDe_id',$orderDe_id)->first();
                //Check mã code tồn tại
                if($code != null){
                    //Check mã code đã kích hoạt
                    if($code->code_status == 1){
                        $course_relate = $cou->group->course;
                        $list_cou_ids = [];
                        foreach ($course_relate as $item) {
                            if ($cou->cou_id != $item->cou_id) {
                                $list_cou_ids[] = $item->cou_id;
                            }
                            
                        }

                        $data['course_relate'] = Course::whereIn('cou_id', $list_cou_ids)->inRandomOrder()->take(3)->get();
                        $data['course'] = $cou;
                        if ($data['course']->group->gr_parent_id != 0) {
                            $data['course']->group = Group::find($data['course']->group->gr_parent_id);
                        }
                        // $data['rat'] = Rating::where('rat_cou_id',$cou->cou_id)->where('rat_acc_id',Auth::user()->id)->first();
                        
                        $data['active'] = true;
                        return view('frontend.course.detail',$data);
                    }
                    else{
                        return redirect('courses/detail/'.$slug.'.html')->with('error','Bạn chưa kích hoạt khóa học này');
                    }
                }
                else return redirect('courses/detail/'.$slug.'.html')->with('error','Bạn đã cố gắng');
            }
            else return back()->with('error','Khóa học của chúng tôi đang trong quá trình bảo trì');
        }
        else return redirect('courses/detail/'.$slug.'.html')->with('error','Bạn phải đăng nhập');
    }

    public function postRate(){
        $star = (int)Input::get('star');
        $content = Input::get('content');
        $cou_id = Input::get('cou_id');
        if (Auth::check()) {
            $rate = Rating::where('rat_acc_id' , Auth::user()->id)->where('rat_cou_id', $cou_id)->first();
            isset($rate) ? '' : $rate = new Rating;
            $rate->rat_star = $star;
            $rate->rat_content = $content;
            $rate->rat_acc_id = Auth::user()->id;
            $rate->rat_cou_id = $cou_id;
            $rate->save();
            $this->reloadRate($cou_id);
            return response('ok', 200);
        }
        else{
            return response('error', 501);
        }   
            
    }
    //Vào trang lấy link chia sẻ
    public function get_aff(){
        $code = (int)Input::get('code');
        $aff = Aff::where('aff_code', $code)->first();
        if ($aff == null) {
            return response('error', 202);
        }
        else{
            $data['acc'] = $aff->acc;
            $view = View::make('frontend.course.aff',$data)->render();
            return response($view, 201);
        }
           
    }
    //Vào trang làm bài kiểm tra
    public function getExam($slug, $id){
        $exam = Exam::find($id);
        if ($exam == null){
            return redirect('/')->with('error', 'Trang không được phép truy cập');
        }
        $user = Account::find(Auth::user()->id);
        if ($exam->cou->cou_slug ==  $slug){
            $cou = $exam->cou;
            if ($cou != null && $cou->cou_status == 1) {

                $orderDe_id = null;
                foreach ($cou->orderDe as $item) {
                    if ($item->order->ord_acc_id == Auth::user()->id) {
                        $orderDe_id = $item->orderDe_id;
                    }
                }
                if ($orderDe_id == null){
                    return redirect('/')->with('error', 'Trang không tồn tại ạ ^^');
                }
                $code = Code::where('code_orderDe_id', $orderDe_id)->first();
                //Check mã code tồn tại
                if ($code != null) {
                    //Check mã code đã kích hoạt
                    if ($code->code_status == 1) {
                        $key = $this->gotoExam($cou);
//                        dd($key);
                        if ($key == -1){
                            return redirect('/')->with('error', 'Bạn bị lỗi nặng rồi');
                        }
                        else if ($key >= $exam->id || $key == 0){
                            if ($this->checkLearnDone($user, $cou) > 0.8){
                                $ques = Question::where('exam_id', $exam->id)->orderBy('order')->get();

                                foreach ($ques as $que){
                                    $que->answer = Answer::where('ques_id', $que->id)->orderBy('order')->get();
                                }
                                $result = Result::where('acc_id', Auth::user()->id)->where('exam_id', $exam->id)->whereNotNull('timeout')->first();
//                                dd($result);
                                if ($result == null){
                                    $result = new Result();

                                    $result->exam_id = $exam->id;
                                    $result->acc_id = $user->id;
                                    $result->score = 0;
                                    $result->total_score = $exam->total_score;
                                    $result->timeout = $this->getTimeOutByM($exam->time);
//                                    $result->save();

                                }
//                                dd($result);
                                $result->save();

//                                dd(explode('-', $result->time_out));
                                $data = [
                                    'exam' => $exam,
                                    'course' => $exam->cou,
                                    'ques' => $ques,
                                    'time_out'=>explode('-', $result->timeout),
                                    'result' => $result
                                ];
                                return view('frontend.course.exam', $data);
                            }
                            else{
                                return back()->with('error', 'Khóa học của bạn chưa học xong');
                            }
                        }
                        else{
                            return redirect()->route('get_exam', ['slug'=>$cou->cou_slug, 'id' => $key])->with('error',  'Bạn phải xong khác bài kiểm tra trước');
                        }


                    }
                    else{
                        return back()->with('error', 'Khóa học của bạn chưa được kích hoạt');
                    }
                }
                else{
                    return back()->with('error', 'Khóa học này không thuộc về bạn');
                }
            }
            else{
                return back()->with('error', 'Khóa học này không còn nữa');
            }


        }
        else{
            return redirect('courses/detail/'.$slug.'.html')->with('error', 'Lỗi truy cập');
        }
    }




    public function getResultExam(Request $request, $id_result){
//        return response('ok', 201);
        $ans = $request->correct;
        if ($ans == null){
            $result = Result::find($id_result);
            $result->update(['timeout' => null]);
            $exam = $result->exam;
            return redirect('courses/detail/'.$exam->cou->cou_slug.'.html/active')->with('error', 'Bài của bạn gặp lỗi , Không nhận được kết quả');
        }else{
            $total_score = 0;
            foreach ($ans as $key=>$an){
                $arr = explode('_', $key);
                $que = Question::find($arr[0]);
                $ans = Answer::find($arr[1]);
                if ($ans->correct == 1){
                    $total_score += $que->score;
                }
                else{
                    $total_score -= (($que->score)/2);
                }
            }
            if ($total_score < 0) $total_score = 0;

            $exam = $que->exam;

            $result = Result::find($id_result);
            if ($result == null){
                return redirect('courses/detail/'.$exam->cou->cou_slug.'.html/active')->with('error', 'Gặp lỗi _ Bài làm của bạn gặp lỗi');
            }

            $result->score = $total_score;
            $result->total_score = $exam->total_score;
            $result->timeout = null;
            $result->save();
            $next_exam = Exam::where('cou_id', $exam->cou_id)->where('order', $exam->order + 1 )->first();

            $data = [
                'score'=> $total_score,
                'total_score'=> $exam->total_score,
                'exam' => $exam,
                'course' => $exam->cou,
                'next_exam' => $next_exam
            ];
            return view('frontend.course.result', $data);
//            return redirect('courses/detail/'.$exam->cou->cou_slug.'.html/active');
//            dd($result);
//            dd($total_score);
        }



    }
    public function gotoExam(Course $cou){
        //Không có khóa học thì trả về -1
//        dd($cou);
        if ($cou == null) return -1;
        //Tìm các bài kiểm tra của khóa học
        $exams = Exam::where('cou_id', $cou->cou_id)->orderBy('order', 'asc')->get();

        foreach($exams as $exam){
            //Lấy ra kết  quả của người dùng với từng bào kiểm tra
            $results = Result::where('exam_id', $exam->id)->where('acc_id',Auth::user()->id)->get();
            //Chưa xong
            $done = 0;
            foreach ($results as $result) {
                //Nếu kết quả bài kiểm tra qua
                if ($result->score/$result->total_score >= Exam::PASS){
                    //Kết quả PASS
                    $done = 1;
                }
            }
            //Khi không qua
            if ($done == 0){
                //trả về id bài kiểm tra không qua
                return $exam->id;
            }
        }
        return 0;

    }

    public function getListExam($cou_id){
        $course = Course::find($cou_id);
        $exams = Exam::where('cou_id', $cou_id)->orderBy('order', 'asc')->get();

        foreach ($exams as $exam){
            $results = Result::where('acc_id', Auth::user()->id)->where('exam_id', $exam->id)->orderBy('updated_at', 'asc')->get();
            $exam->results = $results;
        }
        $data = [
            'exams' =>$exams,
            'course' => $course
        ];
        return view('frontend.course.list_exam',$data );

    }
    public function Examgoto($cou_slug){
        $course = Course::where('cou_slug', $cou_slug)->first();
        $key = $this->gotoExam($course);
        if ($key == -1){
            return redirect('/')->with('error', 'Lỗi không tìm thấy bài kiểm tra');
        }
        else if($key == 0){
            return redirect('courses/list_exam/'.$course->cou_id)->with('success', 'Bạn đã vượt qua tất cả bài kiểm tra');
        }
        else{
            return redirect('courses/detail/'.$course->cou_slug.'.html/exam/'.$key);
        }

    }
    //Cập nhật thời gian mỗi 5s
    public function updateTimeoutExam(){

        $exam_id = (int)Input::get('id');
        $timeout = Input::get('timeout');
//        return response($timeout, 201);
        $acc_id = (int)Input::get('acc_id');
        $result = Result::where('exam_id', $exam_id)->where('acc_id', $acc_id)->where('timeout','!=', null)->first();
        $result->update(['timeout'=>$timeout]);

        return response($result->timeout, 201);
    }


    public function ExamDone(){
        return "Chúc mừng bạn";
    }


}

