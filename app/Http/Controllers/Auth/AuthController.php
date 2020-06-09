<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\NicknameRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Repositories\Interfaces\ProfileRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function validateUser(RegistrationRequest $request)
    {
        $validated = $request->validated();

        return  response()->json(['status' => 'success'], 200);
    }

    public function register(Request $request, ProfileRepositoryInterface $profileRepository)
    {
        $dboA = DB::connection();
        $dboB = DB::connection('pgsql_auth');

        $dboA->beginTransaction();
        $dboB->beginTransaction();

        try
        {
            $nickname = $request->input('nickname');
            $email = $request->input('email');
            $password = bcrypt($request->input('password'));

            $user = new User;
            $user->nickname = $nickname;
            $user->email = $email;
            $user->password = $password;
            $user->save();

            $request->request->add([ 'id' => $user->id]);
            $request = $request->only($profileRepository->getModel()->getFillable());
            $profileRepository->create($request);

            $dboA->commit();
            $dboB->commit();
        } catch (\Exception $e) {
            $dboA->rollBack();
            $dboB->rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return  response()->json(['status' => 'success'], 200);
    }

    public function test(){
        return DB::select(DB::raw('select current_user;'));
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
            DB::purge( 'pgsql_guest');
            DB::connection('pgsql_root');
        }
        else if($user->isAdmin()){
            DB::setDefaultConnection('pgsql_admin');
            DB::purge( 'pgsql_guest');
            DB::connection('pgsql_admin');
        }
        else{
            DB::setDefaultConnection('pgsql_user');
            DB::purge( 'pgsql_guest');
            DB::connection('pgsql_user');
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
