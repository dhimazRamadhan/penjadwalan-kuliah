<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PenjadwalanModel;
use Illuminate\Support\Facades\DB;

class test extends Controller
{
    public function index()
    {
        $obj_penjadwalan = new PenjadwalanModel();
        $post = $obj_penjadwalan->GetSks(1);
        return response()->json([
            'success' => true,
            'count' => count($post),
            'message' => 'sks',
            'data'    => $post
        ], 200);
    }
}
