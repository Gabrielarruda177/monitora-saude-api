<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Etapa 1: Cadastro inicial (agora com foto opcional)
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
            // 🚨 CAMPO 'FOTO' ADICIONADO AQUI
            'foto' => 'nullable|string', 
        ]);

        if (isset($data['senha'])) {
            // Garante que o campo 'senha' seja criptografado se estiver presente
            $data['senha'] = bcrypt($data['senha']); 
        }

        $user = User::create($data);

        return response()->json(['id' => $user->id], 201);
    }

    // Etapa 2 e 3: Atualização dos dados (com foto)
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }

        // 🚨 VALIDAÇÃO ÚNICA E CORRETA
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
            'foto' => 'nullable|string', // 🚨 CAMPO 'FOTO' MANTIDO
        ]);

        if (isset($data['senha'])) {
            // Criptografa a nova senha se ela for enviada
            $data['senha'] = bcrypt($data['senha']); 
        }
        
        $user->update($data);

        return response()->json(['success' => true]);
    }

    // Login (Mantido)
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