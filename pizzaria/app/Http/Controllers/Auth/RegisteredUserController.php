<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Mostra a view de cadstro
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Lida com uma requisição de cadastro
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        //valida os dados que chegam na requisição e aplica regras
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        //caso passado pelas regras, cria um novo usuario
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //cria um evento anunciando o usuario criado
        event(new Registered($user));

        //faz o login no sistema com as credenciais do cadastro
        Auth::login($user);

        //caso tenha sido impedido de acessar alguma rota, o laravel vai tentar devolve-lo a rota
        return redirect(RouteServiceProvider::HOME);
    }
}
