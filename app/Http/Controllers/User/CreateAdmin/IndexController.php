<?php

namespace App\Http\Controllers\User\CreateAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class IndexController extends Controller
{
    public function __invoke()
    {
        $isNotAdmin = isset(User::where('email', 'admin@admin')->get()[0]->name) == false;

        if($isNotAdmin) {
            Artisan::call('db:seed --class=AdminSeeder');
        }

        $user = User::where('email', 'admin@admin')->get();

        return response()->json(['data'=> ['email' => $user[0]->email, 'password' => 'admin']], 200);
    }
}
