<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    //
    public function index()
    {
        // return 'Index';
        // dd(Auth::user());
        // Auth::check();

        // Listing::make([
        //     'beds' => 2, 'baths' => 2, 'area' => 100, 'city' => 'North', 'street' => 'Tinker st', 'street_nr' => 20, 'code' => 'TS', 'price' => 200_000
        // ])

        // dd(
        //     Hash::make('password'),
        //     '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        //     Hash::check('password', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
        // );

        return inertia(
            'Index/Index',
            [
                'message' => 'Hello from Laravel'
            ]
        );
    }

    public function show()
    {
        // return 'Show';
        return inertia('Index/Show');
    }
}
