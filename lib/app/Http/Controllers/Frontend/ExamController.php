<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function getExam($id){

        $exam = Exam::find($id);
        if ($exam == null){
            return redirect('/')->with('error', 'Lỗi không tìm thấy bài kiểm tra');
        }
        $this->updateTotalScore($exam);

        if ($exam->cou->tea->id == Auth::user()->id){

            $ques = Question::where('exam_id', $exam->id)->orderBy('order')->get();

            foreach ($ques as $que){
                $que->answer = Answer::where('ques_id', $que->id)->orderBy('order')->get();
            }
            if ($exam->time_out == null){
                $exam->time_out = 0-15-0;
            }

            $data = [
                'exam' => $exam,
                'course' => $exam->cou,
                'ques' => $ques

            ];
            return view('frontend.teacher.exam', $data);
        }
        else{
            return redirect('teacher/course');
        }
    }

    public function postAdd(Request $request, $cou_id){
//        dd('ok');
        $data = $request->all();
        $data['cou_id'] = $cou_id;
        if ($request->order == null){
            $exam_order = Exam::where('cou_id', $cou_id)->orderBy('order', 'desc')->first();
            if ($exam_order == null){
                $data['order'] = 1;
            }
            else{
                $data['order'] = $exam_order->order+1;
            }
        }
        $exam_id = Exam::create($data)->id;
        if ($exam_id != null){
            return redirect('teacher/exam/'.$exam_id)->with('success', 'Tạo bài thi thành công');
        }
        else{
            return back()->with('error', 'Tạo bài thi bị lỗi');
        }
    }
    public function postEdit(Request $request, $id){
        $exam = Exam::find($id);
        $data = $request->all();

        if ($exam->update($data)){
            return back()->with('success', 'Sửa bài thi thành công');
        }
        else{
            return back()->with('error', 'Sửa bài thi bị lỗi');
        }
    }

    public function updateTotalScore(Exam $exam){
        $total_score = 0;
        $total_score += Question::where('exam_id', $exam->id)->selectRaw('sum(score) as score')->first()->score;
//        dd($total_score);
        $exam->update(['total_score'=> $total_score]);
//        return true;
    }

    public function getDelete($exam_id){
        $exam = Exam::find($exam_id);
        if ($exam == null){
            return back()->with('error', 'Lỗi không tìm thấy bài kiểm tra');
        }
        if ($exam->cou->tea->id == Auth::user()->id){
            $exam->delete();
            return back()->with('success', 'Xóa bài thi thành công');

        }
        else{
            return back()->with('error', 'Lỗi quyền truy cập');
        }


    }

    public function updateOrder(Request $request){
        $exam_orders = $request->exam;
        if ($exam_orders == null) return back();
        foreach($exam_orders as $key=>$exam_order){
            $exam = Exam::find($key);
            $exam->update(["order"=> $exam_order]);
        }
        return back();
        dd($exam_orders);
    }
}
