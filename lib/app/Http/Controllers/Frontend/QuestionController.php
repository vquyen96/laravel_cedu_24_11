<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Answer;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{

    public function addAll(Request $request, $exam_id){
        $ques = $request->que;
        $ques_order = Question::where('exam_id', $exam_id)->orderBy('order', 'desc')->first();
        if ($ques_order == null){
            $ques_order = 1;
        }
        else{
            $ques_order = $ques_order->order+1;
        }
        $ques['order'] = $ques_order;
        $ques['exam_id'] = $exam_id;
        $ques_id = Question::create($ques)->id;
        if ($ques_id == null){
            return back()->with('error','Lỗi Thêm câu hỏi');
        }
//        $arr_ans = [];
        foreach ($request->ans as $key=>$ans){
            if (strpos($key, 'correct_') !== false){
                $correct_key = (int)str_replace('correct_','',$key);
            }
        }
        if (!isset($correct_key)) $correct_key = 0;
        foreach ($request->ans as $key=>$ans){
            if (strpos($key, 'name_') !== false && $ans != null){
                $ans_key = (int)str_replace('name_','',$key);
                $correct_key == $ans_key ? $correct = 1 : $correct = 0;
                $ans_order = Answer::where('ques_id', $ques_id)->orderBy('order', 'desc')->first();
                if ($ans_order == null){
                    $ans_order = 1;
                }
                else{
                    $ans_order = $ans_order->order+1;
                }
                $data = [
                    'name' => $ans,
                    'ques_id' => $ques_id,
                    'correct' => $correct,
                    'order' => $ans_order
                ];
                if (!Answer::create($data)){
                    return back()->with('error','Gặp lỗi khi thêm câu trả lời');
                }
            }
        }


        return back()->with('success','Thêm mới thành công');

    }
    public function postAdd(Request $request, $exam_id){

        $exam = Exam::find($exam_id);
        if ($request->order == null){
            $ques_order = Question::where('exam_id', $exam_id)->orderBy('order', 'desc')->first();
            if ($ques_order == null){
                $ques_order = 1;
            }
            else{
                $ques_order = $ques_order->order+1;
            }
        }
        else{
            $ques_order = $request->order;

        }

        $data = [
            'name' => $request->name,
            'exam_id' => $exam_id,
            'score' => $request->score,
            'num_ans' => $request->num_ans,
            'order' => $ques_order
        ];
        if (Question::create($data)){
            $this->updateOrderQues($exam);
            return back()->with('success','Thêm mới câu hỏi thành công');
        }
        else{
            return back()->with('error','Thêm mới câu hỏi bị lỗi');
        }
    }
    public function postEdit(Request $request, $que_id){
        $que = Question::find($que_id);
        $data = [
            'name' => $request->name,
            'score' => $request->score,
            'num_ans' => $request->num_ans,
        ];
        if ($que->update($data)){
            $this->updateOrderQues($que->exam);
            return back()->with('success','Sửa câu hỏi thành công');
        }
        else{
            return back()->with('error','Sửa câu hỏi bị lỗi');
        }
    }
    public function postDelete($que_id){
        $ques = Question::find($que_id);
        if ($ques != null){
            $ques->delete();
            $this->updateOrderQues($ques->exam);
        }
        return response('OKe', 201);

    }

    public function updateOrderQues(Exam $exam){
        $ques = Question::where('exam_id', $exam->id)->orderBy('order', 'asc')->get();
        foreach ($ques as $index=>$que){
            $que->update(['order'=>($index+1)]);
        }
    }

    public function postSort(Request $request){
//        dd($request->data);
        $orders = $request->data;
        foreach ($orders as $order){
            $arr = explode("--", $order);
            $ques = Question::find($arr[1]);
            $ques->update(['order' => $arr[0]]);

        }
        return response('OKe', 201);
    }
}
