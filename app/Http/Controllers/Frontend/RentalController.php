<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Car;
use App\Models\Rental;
use Illuminate\Http\Request;
use App\Mail\RentalNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class RentalController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Create the rental record
        $rental = Rental::create([
            'user_id' => auth()->id(),
            'car_id' => $request->car_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_cost' => $this->calculateTotalCost($request->car_id, $request->start_date, $request->end_date),
        ]);

        // Send email to the customer
        Mail::to($rental->user->email)->send(new RentalNotification($rental));

        // Send email to the admin
        Mail::to('admin@example.com')->send(new RentalNotification($rental));

        // Redirect to a page (for example, the user's bookings page)
        return redirect()->route('rentals.index')->with('success', 'Rental booked successfully.');
    }

    private function calculateTotalCost($carId, $startDate, $endDate)
    {
        // Calculate total cost based on the car's daily rent price and rental duration
        $car = Car::findOrFail($carId);
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        $days = $end->diffInDays($start);
        
        return $car->daily_rent_price * $days;
    }
}

