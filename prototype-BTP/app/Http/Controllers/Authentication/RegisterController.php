<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authentication\RegisterRequest;
use App\Services\Authentication\RegisterService;

class RegisterController extends Controller
{
    protected RegisterService $registerService;

    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function index()
    {
        return view('registersys.daftarPenyewa');
    }

    public function checkUnique(RegisterRequest $request)
    {
        $field = $request->input('field');
        $value = $request->input('value');
        $exists = $this->registerService->checkUnique($field, $value);

        return response()->json(['exists' => $exists]);
    }

    public function store(RegisterRequest $request)
    {
        $this->registerService->registerAdmin($request->validated());

        return redirect('/login')->with('success', 'Registration Successful~ Please Login!');
    }
}
