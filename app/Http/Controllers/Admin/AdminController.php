<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashbord()
    {
        return view('admin.dashbord');
    }

    public function login(){
        return view('admin.login');
    }
}

/*namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashbord (){
        return view('admin.dashbord');
    }
}
*/
