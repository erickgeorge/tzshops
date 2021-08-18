<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

trait RegistersUsers
{
    use RedirectsUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }


        public function registeruser(Request $request)
    {


        $request->validate([
            'name' => 'required|unique:users',
            'lname' => 'required',
            'fname' => 'required',
            'phone' => 'required|unique:users',
       

        ]);


       $user = new User();
       $user->name = $request['name'];
       $user->fname = $request['fname'];
       $user->lname = $request['lname'];
       $user->phone = $request['phone'];
       $user->type = 'Owner';
       $user->password =  Hash::make($request['pass']);
       if ($request['pass'] != $request['confirmpass']) {
           return redirect()->back()->withErrors(['message'=>'The passwords you entered does not match. Please re-submit your form again']);
       }
      
       $user->save();

       return redirect()->route('login')->with(['message'=>'You have succesfully registered on shops management system! Please log in to start manages your salary. Thank You.']);


    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }
}
