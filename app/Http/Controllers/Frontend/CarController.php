<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CarController extends Controller
{
    public function index() {
        $cars = Car::where('availability', true)->get();
        return view('frontend.cars.index', compact('cars'));
    }
}

