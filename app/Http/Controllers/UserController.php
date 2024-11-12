<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    private $indexView = 'welcome';
    private $signupView = 'signup';
    private $loginView = 'welcome';
    private $editView = 'edit';
    private $dashboardView = 'dashboard';


    public function index()
    {
        return view($this->indexView);
    }
    
    public function signup()
    {
        return view($this->signupView);
    }

    public function userCreate(Request $request)
    {

        $rules = [
            'first_name'   => 'required',
            'last_name'    => 'required',
            'username'     => 'required',
            'phone'        => 'required|unique:users,phone',
            'email'        => 'required|email|unique:users,email',
            'password'     => 'required',
        ];
        
        $messages = [
            'first_name.required'     => 'First Name is required',
            'last_name.required'      => 'Last Name is required',
            'username.required'       => 'UserName is required',
            'phone.required'          => 'Phone No is required',
            'phone.unique'            => 'This phone number is already taken',
            'email.required'          => 'Email is required',
            'email.unique'            => 'This email address is already taken',
            'email.email'             => 'Please provide a valid email address',
            'password.required'       => 'Password is required',
        ];
        

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        Users::create([
            'first_name'  => $request->first_name,
            'last_name'   => $request->last_name,
            'username'    => $request->username,
            'phone'       => $request->phone,
            'email'       => $request->email,
            'password'    => $request->password,
        ]);


        return redirect()->route('index')->with('success', 'Account successfully created!');

    }


    public function login(Request $request)
    {
        if ($request->email && $request->password) {
     
            $user = Users::where('email', $request->email)
                         ->where('password', $request->password)
                         ->first();
    
     
            if ($user) {
    
                return view($this->dashboardView, ['user' => $user]);
            }
    
            return redirect()->back()->withErrors(['login' => 'Invalid credentials']);
        }
    
    }
    

    public function forgotPassword(Request $request)
    {

        return view($this->editView);
    }
    

    public function forgotPasswordVerify(Request $request)
    {


        $rules = [
            'phone'    => 'required',
            'email'    => 'required',
            'password' => 'required',
        ];

        $messages = [
            'phone.required'     => 'First Name is required',
            'email.required'     => 'Last Name is required',
            'password.required'  => 'UserName is required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = Users::where('phone', $request->phone)
        ->where('email', $request->email)
        ->first();

        if ($user) {
            $user->password = $request->password;
            $user->save();

            return redirect()->route('index')->with('success', 'Password updated successfully!');

        } else {
            
            return redirect()->back()->withErrors(['message' => 'Phone number or email is incorrect.'])->withInput();
        }
            
       

        return view($this->editView);
    }


    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('index');
    }
    

    public function checkInformation(Request $request)
    {

        if ($request->has('phone')) {
            $exists = Users::where('phone', $request->phone)->exists();
            return response()->json(['exists' => $exists]);
        }
    
        if ($request->has('email')) {
            $exists = Users::where('email', $request->email)->exists();
            return response()->json(['exists' => $exists]);
        }
    
        return response()->json(['exists' => false]);
    }
    
    
}
