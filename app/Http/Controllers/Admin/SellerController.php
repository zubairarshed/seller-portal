<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SellerApplication;

class SellerController extends Controller
{
    public function deleteList() {
        $sellers = User::where('role', 'seller')->get();
        return view('admin.sellers.delete', compact('sellers'));
    }

    public function destroy(User $seller) {
        // Update status in seller_applications table
        SellerApplication::where('email', $seller->email)
            ->update(['status' => 'deleted']);
        
        $seller->delete();
        return redirect()->route('admin.seller_delete')->with('message', 'Seller deleted successfully.');
    }
}
