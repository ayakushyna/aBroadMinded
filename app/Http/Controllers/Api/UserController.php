<?php


namespace App\Http\Controllers\Api;


use App\Http\Requests\EmailRequest;
use App\Http\Requests\NicknameRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\RoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController
{
    public function show($id)
    {
        $user = User::find($id);

        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    public function getRoles()
    {
        $data =  User::ROLES;

        return  response()->json(
            [
                'items' => $data
            ], 200);
    }

    public function updateEmail(EmailRequest $request, $id)
    {
        return User::findOrFail($id)->update($request->only('email'));
    }

    public function updateNickname(NicknameRequest $request, $id)
    {
        return User::findOrFail($id)->update($request->only('nickname'));
    }

    public function updatePassword(PasswordRequest $request, $id)
    {
        $password = bcrypt($request->input('password'));
        return User::findOrFail($id)->update(['password' => $password]);
    }

    public function updateRole(RoleRequest $request, $id)
    {
        return User::findOrFail($id)->update($request->only('role'));
    }

    public function destroy($id)
    {
       User::destroy($id);

        return response()->json([
            'status' => 'success'
        ]);
    }

}
