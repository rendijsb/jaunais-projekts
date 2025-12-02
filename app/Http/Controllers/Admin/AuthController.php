<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Admin\AuthRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthRepository $authRepository
    ) {
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!$this->authRepository->attempt($request)) {
            return response()->json(['message' => 'Invalid credentials.'], 422);
        }

        return response()->json(['redirect' => '/admin/dashboard']);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authRepository->logout($request);

        return response()->json(['redirect' => '/admin/login']);
    }
}
