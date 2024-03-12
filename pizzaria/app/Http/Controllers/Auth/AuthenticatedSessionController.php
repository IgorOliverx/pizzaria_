<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


    /*
    * Essa classe representa o controller de um usuário que precisa autenticar antes
     * de realizar alguma ação
    */
class AuthenticatedSessionController extends Controller
{
    /**
     * Retona a view logada
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Lida com uma solicitação de autenticação recebida
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        //autentica o usuário
        $request->authenticate();

        //regenera a sessão para evitar ataques
        $request->session()->regenerate();


        //tenta redirecionar o usuário para a página que
        // ele estava tentando acessar antes de ser barrado pelo middleware
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Excluir a sessão autenticada
     */
    public function destroy(Request $request): RedirectResponse
    {
        //Basicamente pega o que estiver autenticado e faz o logout(não aponta usuários específicos)
        Auth::guard('web')->logout();

        //invalida a sessão
        $request->session()->invalidate();

        //regenera o token de sessão por segurança
        $request->session()->regenerateToken();

        //redireciona para a home
        return redirect('/');
    }
}
