<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Hari;
use Illuminate\Support\Facades\DB;

class HariController extends Controller
{

    public function index()
    {
        $post = Hari::get();
        //make response json
        return response()->json([
            'success' => true,
            'count' => count($post),
            'message' => 'List Data Hari',
            'data'    => $post
        ], 200);
    }

    public function show($kode)
    {
        $post = DB::table('hari')
            ->where('kode', $kode)
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Hari',
            'data'    => $post
        ], 200);
    }
}
