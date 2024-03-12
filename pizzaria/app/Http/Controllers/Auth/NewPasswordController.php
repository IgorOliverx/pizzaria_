<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class NewPasswordController extends Controller
{
    /**
     * View para criar uma nova senha (só pode ser acessada por usuários ja autenticados)
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * função para lidar com uma nova solicitação de senha recebida
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        //Valida todos os campos que chegaram na requisição
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Aqui tentaremos redefinir a senha do usuário. COMO?
        // Com os dados do usuário batendo com o que veio da requisição
        // usaremos o forceFill para forçar uma troca de senha e depois salvar no banco de dados
        $status = Password::reset( //classe Password e método estatico reset
            //only agrupa o que eu passar em um array assoc
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // if a senha foi resetada = Volta para a visualização do perfil
        // else redirecionar para onde a mensagem de erro apontou(varia conforme o erro, podendo jogar me varias views)
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                            ->withErrors(['email' => __($status)]);
    }
}
