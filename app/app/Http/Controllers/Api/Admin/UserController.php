<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'is_admin']);
        $users = $this->userService->getUsers($filters, $request->get('per_page', 20));
        return response()->json($users);
    }

    public function show($id)
    {
        $user = $this->userService->getUser($id);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'is_admin' => 'boolean',
        ]);

        $user = $this->userService->createUser($validated);
        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'username' => 'sometimes|string|max:100|unique:users,username,' . $id,
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'is_admin' => 'boolean',
        ]);

        $user = $this->userService->updateUser($id, $validated);
        return response()->json($user);
    }

    public function destroy($id)
    {
        // Không cho xóa user đang đăng nhập
        if ($id == auth()->id()) {
            return response()->json(['error' => 'Cannot delete yourself'], 422);
        }

        $this->userService->deleteUser($id);
        return response()->json(['message' => 'Deleted']);
    }
}