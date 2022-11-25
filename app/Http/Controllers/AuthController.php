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

    }

    public function logout() {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh() {
        $token = auth('api')->refresh(); //clint encaminhe um jwt válido
        return response()->json(['token' => $token]);

    }

    public function me() {
        return response()->json(auth()->user());
    }

}
