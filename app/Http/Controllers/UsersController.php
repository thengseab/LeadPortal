<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller
{
    public function index(){
        
        return view("book");
    }
    public function login(){
        return view('login');
    }
    public function isLogin(Request $request){
        $this->validate($request,[

            'username'    =>'required',
            'password' =>'required'

        ]);

        if (Auth::attempt(['name' => $request->username, 'password' => $request->password])) {
            if(Auth::user()->user_type=="admin"){
                return redirect()->route('dashboard');
            }else{
                return "Author username";
            }
            
        } else {
            return redirect()->back()->withInput()->withErrors(['error'=>'Username and password not match!']);
        }
    }

    public function dashboard(){
        $username=Auth::user()->id;
        return view("admin.index");
    }

    public function logout(){
        Auth::logout();
        return redirect('admin');
    }
}
