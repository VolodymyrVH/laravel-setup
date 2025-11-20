<?php
namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Валідація
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Шукаємо користувача
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Невірний email або пароль'], 401);
        }

        // Створюємо токен
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }

    public function logout(Request $request)
    {
        // Анулюємо токен, який використовується для поточного запиту
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Вихід успішний']);
    }

}
