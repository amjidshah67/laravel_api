<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DemoController extends Controller
{
    public function Index()
    {
        $array = [
            [
                'name' => 'Amjad shsh',
                'email' => 'amjid123@gmail.com'
            ],
            [
                'name' => 'Ali shsh',
                'email' => 'ali123@gmail.com'
            ]
        ];
        return response()->json([
            'message' =>  '2 Users Found',
            'data' => $array,
            'status' => true
        ],200);
    }
}
