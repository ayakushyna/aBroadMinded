<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationFormRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Register a new user
     * @param RegistrationFormRequest $request
     * @return JsonResponse
     */
    public function register(RegistrationFormRequest $request)
    {
        $validated = $request->validated();

        $nickname = $request->nickname;
        $email = $request->email;
        $password = bcrypt($request->password);

        DB::connection('pgsql_auth')->table('users')->insert([
                'nickname' => $nickname ,
                'email' => $email,
                'password' => $password]
        );

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Login user and return a token
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $login = $request->login;
        $password = $request->password;

        if ($token = $this->guard()->attempt(['email' => $login, 'password' => $password])) {
            $this->setDefaultConnection();

            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
        }

        if ($token = $this->guard()->attempt(['nickname' => $login, 'password' => $password])) {
            $this->setDefaultConnection();

            return response()->json(['status' => 'success'], 200)->header('Authorization', $token);

        }
        return response()->json(['error' => 'login_error'], 401);
    }

    public function setDefaultConnection()
    {
        $user = User::find(Auth::user()->id);

        if($user->isRoot()){
            DB::setDefaultConnection('pgsql_root');
        }
        else if($user->isAdmin()){
            DB::setDefaultConnection('pgsql_admin');
        }
        else{
            DB::setDefaultConnection('pgsql_user');
        }

    }

    /**
     * Logout User
     */
    public function logout()
    {
        $this->guard()->logout();
        DB::setDefaultConnection('pgsql_guest');

        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    /**
     * Get authenticated user
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }
    /**
     * Refresh JWT token
     */
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }
    /**
     * Return auth guard
     */
    private function guard()
    {
        return Auth::guard();
    }
}
