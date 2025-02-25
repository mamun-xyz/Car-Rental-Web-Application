<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rental;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RentalController extends Controller
{
    public function index() {
        $rentals = Rental::with('user', 'car')->get();
        return view('admin.rentals.index', compact('rentals'));
    }

    public function destroy(Rental $rental) {
        $rental->delete();
        return redirect()->route('admin.rentals.index');
    }
}
