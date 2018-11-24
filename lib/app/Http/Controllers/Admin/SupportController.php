<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gift;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupportController extends Controller
{
    public function getList(){
        $data['items'] = Gift::orderByDesc('gift_id')->get();
        return view('backend.support.support', $data);
    }

}
