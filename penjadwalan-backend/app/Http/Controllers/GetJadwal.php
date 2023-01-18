<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PenjadwalanModel;

class GetJadwal extends Controller
{
    public function index()
    {
        $jadwal = new PenjadwalanModel();
        $data = $jadwal->GetJadwal();

        // make response JSON
        return response()->json([
            'success' => true,
            'message' => 'List Jadwal',
            'count' => count($data),
            'data'    => $data
        ], 200);
    }
}
