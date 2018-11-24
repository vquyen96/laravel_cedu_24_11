<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CKFinderController extends Controller
{
    public function connector(){
        require_once public_path("/../../public/ckfinder/core/connector/php/connector.php");
    }

    public function ckfinder_view(){
        return view('backend.ckfinder.ckfinder_view');
    }
}
