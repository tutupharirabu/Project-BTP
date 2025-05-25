<?php

namespace App\Http\Controllers\Authentication;

use App\Enums\Admin\RoleAdmin;
use App\Enums\Database\UsersDatabaseColumn;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Authentication\LoginService;
use App\Http\Requests\Authentication\LoginRequest;

class LoginController extends Controller
{
    protected LoginService $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function index()
    {
        return view('loginsys.login', [
            'title' => 'login',
            'active' => 'login'
        ]);
    }

    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->only([UsersDatabaseColumn::Email->value, UsersDatabaseColumn::Password->value]);

        if ($this->loginService->authenticate($credentials)) {
            $user = $this->loginService->adminOrPetugas();

            if (in_array($user->role, [RoleAdmin::Admin->value, RoleAdmin::Petugas->value])) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboardAdmin');
            }
        }

        return back()->with('loginError', 'Login Failed~');
    }

    public function logout(Request $request)
    {
        $this->loginService->logout();
        $request->session()->forget([UsersDatabaseColumn::IdUsers->value, UsersDatabaseColumn::Email->value]);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('justLoggedOut', true);
    }
}
