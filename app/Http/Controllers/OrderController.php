<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'meal' => 'required|string',
            'restaurant' => 'required|string',
            'dish' => 'required|string',
            'numberOfPeople' => 'required|integer|min:1|max:10',
        ]);
        $order = Order::create([
            'meal' => $validatedData['meal'],
            'restaurant' => $validatedData['restaurant'],
            'dish' => $validatedData['dish'],
            'numberOfPeople' => $validatedData['numberOfPeople'],
        ]);

        return response()->json(['message' => 'Thành công', 'order' => $order]);
    }
}

