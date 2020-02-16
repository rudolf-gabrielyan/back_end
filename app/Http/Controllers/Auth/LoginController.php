<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use DB;
use App\Quotation;
use Validator;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\PayloadFactory;
use Tymon\JWTAuth\JWTManager as JWT;
use Illuminate\Auth\Authenticatable;



class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $credentials = $request->json()->all();

        $data = [];

        if(isset($credentials['accessToken'])) {

            $user = User::where('userID', $credentials['userID'])->get()->first();

            if(empty($user)) {

                $data['full_name'] = $credentials['name'];
                $data['email'] = $credentials['email'];
                $data['accessToken'] = $credentials['accessToken'];
                $data['userID'] = $credentials['userID'];

                User::create($data);

            }

            $user=User::where('email','=',$credentials['email'])->first();

            if (!$userToken=JWTAuth::fromUser($user)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }

            $token = $userToken;

            return response()->json( compact('token','user'));
        }
        else if(isset($credentials['dV'])) {

            $user = User::where('userID', $credentials['dV'])->get()->first();

            if(empty($user)) {

                $data['full_name'] = $credentials['Ad'];
                $data['email'] = $credentials['zu'];
                $data['userID'] = $credentials['dV'];

                User::create($data);

            }

            $user=User::where('email','=',$credentials['zu'])->first();

            if (!$userToken=JWTAuth::fromUser($user)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }

            $token = $userToken;

            return response()->json( compact('token','user'));
        }
        
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json('Username or Password is incorrect', 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        $user = JWTAuth::user();

        return response()->json( compact('token','user'));
    }

    public function getAuthenticatedUser()
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }

        return response()->json(compact('user'));
    }

    public function logout()
    {
        config([
            'jwt.blacklist_enabled' => true
        ]);
        \Cookie::forget('token');
        auth()->logout();
        JWTAuth::invalidate(JWTAuth::parseToken());
        return response()->json(['message' => 'Successfully logged out']);
    }
}
