<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $query = Banner::where('is_active', true);

        if ($request->has('position')) {
            $query->where('position', $request->position);
        }

        $banners = $query->orderBy('sort_order')->get();
        return response()->json($banners);
    }
}