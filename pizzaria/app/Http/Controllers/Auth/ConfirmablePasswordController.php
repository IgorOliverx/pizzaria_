<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

    /*
    * Controller para confirmação de senha na hora do cadastro
    */
class ConfirmablePasswordController extends Controller
{
    /**
     * Mostra a view de confirmação de senha
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirma a senha do usuário
     */
    public function store(Request $request): RedirectResponse
    {
        //Se o usuário não estiver logado, valide os dados apontando para o usuário e validando seus dados
        if (! Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])) {
            //captura uma excessão caso a confirmação seja diferente da senha
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        //confirmando a senha, ele prossegue
        $request->session()->put('auth.password_confirmed_at', time());

        //redireciona o usuário para onde ele estava tentando ir antes de ser impedido para confirmar a senha
        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
