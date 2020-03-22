<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Class HogeController
 * @package App\Http\Controllers\Api
 */
class HogeController extends Controller
{
    /**
     * 疎通確認API
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function hoge(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(['OK']);
    }
}
