<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:registrations,email',
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $registration = Registration::create([
            'email' => $validated['email'],
            'name' => $validated['name'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'session_id' => session()->getId(),
            'status' => false,
        ]);

        return response()->json([
            'message' => 'Đăng ký thành công!',
            'data' => $registration
        ], 201);
    }
}