<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class JsonController extends Controller
{
    public function index()
    {
        $filePath = base_path('dishes.json');
        $json = file_get_contents($filePath);

        $data = json_decode($json, true);

        $availableMeals = [];
        foreach ($data['dishes'] as $dish) {
            $availableMeals = array_merge($availableMeals, $dish['availableMeals']);
        }

        $availableMeals = array_unique($availableMeals);

        return view('welcome', ['availableMeals' => $availableMeals]);
    }
    public function getByMeal(Request $request)
    {
        $meal = $request->input('meal');
        $filePath = base_path('dishes.json');
        $json = file_get_contents($filePath);
        $data = json_decode($json, true);
        $restaurants = [];
        foreach ($data['dishes'] as $dish) {
            if (in_array($meal, $dish['availableMeals'])) {
                $restaurants[$dish['restaurant']] = $dish['restaurant'];
            }
        }
        return response()->json($restaurants);
    }
    public function getDishes(Request $request)
{
    $restaurant = $request->input('restaurant');
    $meal = $request->input('meal');

    // Đọc dữ liệu từ tệp JSON
    $filePath = base_path('dishes.json');
    $json = file_get_contents($filePath);

    // Chuyển đổi chuỗi JSON thành mảng PHP
    $data = json_decode($json, true);

    // Lọc ra các món ăn dựa trên nhà hàng và suất ăn đã chọn
    $dishes = [];
    foreach ($data['dishes'] as $dish) {
        if ($dish['restaurant'] == $restaurant && in_array($meal, $dish['availableMeals'])) {
            $dishes[] = $dish;
        }
    }

    // Trả về danh sách món ăn dưới dạng JSON
    return response()->json($dishes);
}
}
