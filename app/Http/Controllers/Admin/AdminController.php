<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashbord()
    {
        return view('admin.dashbord');
    }

    public function login(Request $request){
        if ($request->isMethod('post')){
            // Super secure password: 123 and username=admin@admin.com
            $data = $request->all();

            $rules = [
                'email' => 'required |email |max:255',
                'password' => 'required',
            ];    
            $customMessages = [
                // Add Custom Messages here
                'email. required' => 'Email is required!',
                'email.email' => 'Valid Email is required',
                'password. required' => 'Password is required',
            ];    
            $this->validate($request,$rules, $customMessages);

            if (Auth::guard('admin')->attempt(['email'=>$data['email'], 'password'=>$data['password'],'status'=>1])){
                return redirect('admin/dashboard');
            }else{
                return redirect()->back()->with('error_message','Invalid Email or Password');
            }
        }
        return view('admin.login');
    }

    public function logout(){
        Auth::guard('admin' )->Logout();
        return redirect('admin/login');
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
