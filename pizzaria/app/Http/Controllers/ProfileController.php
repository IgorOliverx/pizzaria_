<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Método para atualizar informações do usuário
     *
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Deletar a conta do usuário
     */
    public function destroy(Request $request): RedirectResponse
    {
        //confirmação da senha para exclusão de usuário a partir da requisição
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]); //basicamente pega a sessão com o validateWithBag e faz o required da senha para poder excluir

        //aponta para o usuário que veio na requisição
        $user = $request->user();

        //logout nele
        Auth::logout();

        //delete no mesmo usuario
        $user->delete();

        //inválida sessões e regenera o token de sessão
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        //redireciona o usuário para a home
        return Redirect::to('/');
    }
}
