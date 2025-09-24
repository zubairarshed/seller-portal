<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellerApplication;
use App\Models\User;

class SellerApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = SellerApplication::where('status', 'pending')->get();
        return view('admin.seller_applications.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function approve($id)
    {
        $application = SellerApplication::findOrFail($id);

        // Create a new user (seller)
        User::create([
            'name'     => $application->name,
            'email'    => $application->email,
            'password' => $application->password, // already hashed in RegistrationController
            'role'     => 'seller'
        ]);

        // Update status
        $application->status = 'approved';
        $application->save();

        return redirect()->back()->with('message', 'Seller approved and account created!');
    }

    public function reject($id)
    {
        $application = SellerApplication::findOrFail($id);

        // Delete application
        $application->update([
            'status' => 'rejected'
        ]);

        return redirect()->back()->with('message', 'Seller application rejected');
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
