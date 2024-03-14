<?php

namespace App\Models;

//use Illuminate\Contracts\Auth\MustVerifyEmail; //essa interface faz a verificação por email -> preciso de um provedor ja que a rede do senai nao ajuda
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Atributos que serão preenchidos pelo usuário e que eu quero que salve no banco de dados
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'cpf',
        'email',
        'password',
    ];

    /**
     * Atributos que devem ser ocultos e protegidos
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Fazendo cast dos atributos que necessitam um tipo especial/hashs.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
