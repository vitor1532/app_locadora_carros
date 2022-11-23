<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) {
        //autenticação (email e senha)
        $credenciais = $request->all(['email', 'password']);

        $token = auth('api')->attempt($credenciais);

        if($token) {// usuario autenticado com sucesso
            return response()->json(['token' => $token]);
        } else {//erro de usuario ou senha
            return response()->json(['erro' => 'Usuário ou senha inválido(s)!'], 403);
            //403 = forbidden
            //401 = unauthorized
        }

        return 'login';
    }

    public function logout() {
        return 'logout';
    }

    public function refresh() {
        return 'refresh';
    }

    public function me() {
        return 'me';
    }

}
