<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Answer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class AnswerController extends Controller
{
    public function postAdd(Request $request, $ques_id){
        $ans_order = Answer::where('ques_id', $ques_id)->orderBy('order', 'desc')->first();
        if ($ans_order == null){
            $ans_order = 1;
        }
        else{
            $ans_order = $ans_order->order+1;
        }

//        if ($request->correct){
//            $ans_correct = 1;
//        }
//        else{
//            $ans_correct = 0;
//        }
        $data = [
            'name' => $request->name,
            'ques_id' => $ques_id,
            'correct' => $request->correct,
            'order' => $ans_order
        ];
        $id = Answer::create($data)->id;
        if ($id != null){
            $data['id'] = $id;
            $view =  View::make('frontend.teacher.form_ans', $data)->render();
            return response($view, 202);
        }
        else{
            return response('Lỗi tạo mới', 502);
        }
    }
    public function postEdit(Request $request, $ans_id){
        $ans = Answer::find($ans_id);
        if ($request->order == null){
            $ans_order = Answer::where('ques_id', $ans->ques_id)->orderBy('order', 'desc')->first();
            if ($ans_order == null){
                $ans_order = 1;
            }
            else{
                $ans_order = $ans_order->order+1;
            }
        }
        else{
            $ans_order = $request->order;
        }
        if ($request->correct){
            $ans_correct = 1;
        }
        else{
            $ans_correct = 0;
        }
        $data = [
            'name' => $request->name,
            'correct' => $ans_correct,
            'order' => $ans_order
        ];
        if ($ans->update($data)){
            return back()->with('success','Sửa câu trả lời thành công');
        }
        else{
            return back()->with('error','Sửa câu trả lời bị lỗi');
        }
    }

    /**
     * @param $ans_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDelete($ans_id){
        $ans = Answer::find($ans_id);
        if ($ans != null && $ans->ques->exam->cou->tea->id == Auth::user()->id){
            $ans->delete();
        }
        return response('Done', 202);

    }
}
