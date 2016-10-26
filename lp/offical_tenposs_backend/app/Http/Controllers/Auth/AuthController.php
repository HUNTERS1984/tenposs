<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use Auth;
use Session;
use cURL;
use App\Http\Requests;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use App\Repositories\ActivationService;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    
    protected $url_register = 'https://auth.ten-po.com/auth/register';
    protected $url_login = 'https://auth.ten-po.com/auth/login';
    
    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    protected $redirectAfterLogout = '/login';
    
    protected $activationService;
    
    // protected $guard  = 'web';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(ActivationService $activationService)
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
        $this->activationService = $activationService;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function getRegister(){
        return view('pages.signup');
    }

    public function postRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        // Auth::guard($this->getGuard())->login($this->create($request->all()));
        $user = $this->create($request->all());
        // Register to Micro Auth
      
        $response = cURL::post($this->url_register, 
            [
                'email' => $request->input('email'), 
                'password' => $request->input('password'),
                'role' => 'client'
            ]
        );
        
        
        try{
            $this->activationService->sendActivationMail($user);
        }
        catch (Exception $e) {
           
        }
        Session::flash('status','Please check your email to activation your account.');
        return back();
    }

    public function getLogin(){
        return view('pages.login');
    }

    public function postLogin(Request $request)
    {
        $this->validateLogin($request);
        
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        $throttles = $this->isUsingThrottlesLoginsTrait();

        if ($throttles && $lockedOut = $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $credentials = $this->getCredentials($request);

        if (Auth::guard($this->getGuard())->attempt($credentials, $request->has('remember'))) {
            $response = cURL::post($this->url_login, 
                [
                    'email' => $request->input('email'), 
                    'password' => $request->input('password'),
                    'role' => 'client'
                ]
            );
            
            $response = json_decode( $response->body );
            
            if( $response->code == 1000 ){
                Session::put('JWT_token', $response->data);
            }
            
            return $this->handleUserWasAuthenticated($request, $throttles);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        if ($throttles && ! $lockedOut) {
            $this->incrementLoginAttempts($request);
        }

        return $this->sendFailedLoginResponse($request);
    }
    
    public function activateUser( $token ){
        if ($user = $this->activationService->activateUser($token)) {
            auth()->login($user);
            return redirect()->route('user.register.product');
        }
        abort(404);
    }
    
    public function authenticated(Request $request, $user)
    {
        if (!$user->activated) {
            $this->activationService->sendActivationMail($user);
            auth()->logout();
            return back()->with('warning', 'You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        return redirect()->intended($this->redirectPath());
    }
}
