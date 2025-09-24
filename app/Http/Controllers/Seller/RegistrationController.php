<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellerApplication;

class RegistrationController extends Controller
{
    public function create() {
        return view('seller.register');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name'       => 'required|string|min:3|max:255',
            'email'      => 'required|email|unique:seller_applications,email',
            'password'   => 'required|min:6|confirmed'
        ]);

        SellerApplication::create([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'password'   => bcrypt($data['password'])
        ]);

        return redirect()->back()->with('message', 'Your application has been submitted. Wait for admin approval.');
    }
}
