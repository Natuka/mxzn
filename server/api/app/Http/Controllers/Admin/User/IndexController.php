<?php

namespace App\Http\Controllers\Admin\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;

use App\Http\Requests\Admin\User\LoginRequest;
use App\Http\Requests\Admin\User\CreateRequest;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request, User $user)
    {
        $data = $request->only(['mobile', 'qq', 'wechat', 'code', 'email', 'valid', 'name', 'password']);

        $data['valid'] = $request->get('valid', 1);

        $data['code'] = str_random(6);

        $data['password'] = bcrypt($data['password']);

        if (empty($data['wechat'])) {
            $data['wechat'] = str_random(6);
        }

        if (empty($data['qq'])) {
            $data['qq'] = str_random(6);
        }

        // return $data;

        $user->forceFill($data)->save();

        // $user->saveRoles($request->get('roles', []));

        return success_json($user, '创建成功');

    }

    /**
     * 登录
     *
     * @param  LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $user = User::findByEmailMobileName($request->get('account'));

        if (!$user) {
            return error_json('账号不存在');
        }

        $password = e($request->get('password', ''));
         if (!Hash::check($password, $user->password)) {
            return error_json('密码错误');
        }
        $token = $user->createToken('MyToken')->accessToken;

         // 登录成功
        return success_json(compact('token'), '登录成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
