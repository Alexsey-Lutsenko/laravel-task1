<?php

namespace App\Http\Controllers\User\CreateAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateAdminRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StoreController extends Controller
{
    public function __invoke(CreateAdminRequest $request)
    {
        $admin = User::where('email', 'admin@admin')->get()[0];
        $user = $request->validated();

        if (Hash::check($user['password'], $admin->password) && $user['email'] == $admin->email) {
            return response()->json(['data'=> ['isLogin' => true]], 200);
        }

        return response()->json(['data'=> ['isLogin' => false]], 200);
    }
}
