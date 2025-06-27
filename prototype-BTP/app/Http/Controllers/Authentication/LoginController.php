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
        $emailColumn = UsersDatabaseColumn::Email->value;
        $passwordColumn = UsersDatabaseColumn::Password->value;
        $credentials = $request->only([$emailColumn, $passwordColumn]);

        if ($this->loginService->authenticate($credentials)) {
            $user = $this->loginService->adminOrPetugas();

            $adminRole = RoleAdmin::Admin->value;
            $petugasRole = RoleAdmin::Petugas->value;
            $roles = [$adminRole, $petugasRole];

            if (in_array($user->role, $roles)) {
                $request->session()->regenerate();
                return redirect()->intended('/dashboardAdmin');
            }
        }

        return back()->with('loginError', 'Login Failed~');
    }

    public function logout(Request $request)
    {
        $this->loginService->logout();

        $idUsersColumn = UsersDatabaseColumn::IdUsers->value;
        $emailColumn = UsersDatabaseColumn::Email->value;

        $request->session()->forget([$idUsersColumn, $emailColumn]);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('justLoggedOut', true);
    }
}
