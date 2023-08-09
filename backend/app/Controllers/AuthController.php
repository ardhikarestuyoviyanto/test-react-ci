<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Role;
use App\Models\Users;
use Firebase\JWT\JWT;

class AuthController extends BaseController
{
    public function index()
    {
        return response()->setJSON([
            'message' => "Test API..."
        ]);
    }

    public function login()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $userModel = new Users();
        $roleModel = new Role();

        $user = $userModel->where('username', $username)->first();

        if (!$user || !password_verify($password, $user['password'])) {
            return response()->setJSON([
                'message' => "Username or Password Salah"
            ])->setStatusCode(400);
        }

        $issuedAt = time();
        $expire = $issuedAt + env('validFor');
        $role = $roleModel->where('id', $user['id'])->first();

        $data = [
            'iat' => $issuedAt,
            'exp' => $expire,
            'user' => $user,
            'role' => $role['nama_role'],
            'permission' => $roleModel->join('role_permission', 'role_permission.role_id = role.id')
                ->join('permission', 'permission.id = role_permission.permission_id')
                ->where('role.id', $role['id'])
                ->findColumn('hak_akses')
        ];

        $token = JWT::encode($data, env('secretKey'), env('algorithm'));

        return response()->setJSON([
            'token' => $token,
        ]);
    }
}