<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Etapa 1: Cadastro inicial (apenas nome)
    public function store(Request $request)
    {
        $data = $request->validate([
            'nome' => 'required|string|min:2',
            'email' => 'nullable|email|unique:users,email',
            'senha' => 'nullable|string|min:6',
            'peso' => 'nullable|numeric',
            'altura' => 'nullable|numeric',
            'tipo_sanguineo' => 'nullable|string',
            'cep' => 'nullable|string',
            'logradouro' => 'nullable|string',
            'complemento' => 'nullable|string',
            'bairro' => 'nullable|string',
            'cidade' => 'nullable|string',
            'estado' => 'nullable|string',
        ]);

        if (isset($data['senha'])) {
            $data['senha'] = bcrypt($data['senha']);
        }

        $user = User::create($data);

        return response()->json(['id' => $user->id], 201);
    }

    // Etapa 2 e 3: Atualização dos dados
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        $data = $request->validate([
            'nome' => 'nullable|string|min:2',
            'email' => 'nullable|email|unique:users,email,' . $id,
            'senha' => 'nullable|string|min:6',
            'peso' => 'nullable|numeric',
            'altura' => 'nullable|numeric',
            'tipo_sanguineo' => 'nullable|string',
            'cep' => 'nullable|string',
            'logradouro' => 'nullable|string',
            'complemento' => 'nullable|string',
            'bairro' => 'nullable|string',
            'cidade' => 'nullable|string',
            'estado' => 'nullable|string',
        ]);

        if (isset($data['senha'])) {
            $data['senha'] = bcrypt($data['senha']);
        }

        $user->update($data);

        return response()->json(['success' => true]);
    }

    // Login
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'senha' => 'required|string'
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['senha'], $user->senha)) {
            return response()->json(['success' => false], 401);
        }

        return response()->json(['success' => true, 'usuario' => $user]);
    }
}
