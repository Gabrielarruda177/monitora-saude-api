<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome', 'data_nasc', 'peso', 'altura', 'tipo_sanguineo',
        'cep', 'logradouro', 'complemento', 'bairro', 'cidade', 'estado',
        'email', 'senha', 'foto'
    ];

    protected $hidden = ['senha'];
}
