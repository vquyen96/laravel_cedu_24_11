<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Gift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupportController extends Controller
{
    public function getSupport(){
        return view('frontend.support.support');
    }
    public function postSupport(Request $request){
        $sup = $request->support;
        if (Gift::create($sup)) {
            return back()->with('success', 'Yêu cầu của bạn đã được gửi');
        }
        else{
            return back()->with('error', 'Yêu cầu của bạn đã bị lỗi');
        }
    }
}
