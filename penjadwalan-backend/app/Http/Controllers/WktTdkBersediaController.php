<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WktTdkBersedia;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class WktTdkBersediaController extends Controller
{
    public function index()
    {
        $post = DB::select('select a.kode as "kode",
        b.nama as "nama",
        c.nama as "hari",
        d.range_jam as "jam"
        from waktu_tidak_bersedia a 
        join dosen b on a.kode_dosen = b.kode
        join hari c on a.kode_hari = c.kode
        join jam d on a.kode_jam = d.kode');

        return response()->json([
            'success' => true,
            'message' => 'List Data Waktu Tidak Bersedia',
            'count'   => count($post),
            'data'    => $post,
        ], 200);
    }

    public function show($kode)
    {
        $post = DB::table('waktu_tidak_bersedia')
            ->where('kode', $kode)
            ->get();
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Data',
                'data'    => $post
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_dosen'     => 'required',
            'kode_hari'      => 'required',
            'kode_jam'       => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $post = WktTdkBersedia::create([
            'kode_dosen'     => $request->kode_dosen,
            'kode_hari'      => $request->kode_hari,
            'kode_jam'       => $request->kode_jam,
        ]);
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Data Created',
                'data'    => $post
            ], 201);
        }
        return response()->json([
            'success' => false,
            'message' => 'Data Failed to Save',
        ], 409);
    }

    public function update(Request $request, $kode)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'kode_dosen'    => 'required',
            'kode_hari'     => 'required',
            'kode_jam'      => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }
        $post = WktTdkBersedia::where('kode', $kode)->update([
            'kode_dosen'    => $request->kode_dosen,
            'kode_hari'     => $request->kode_hari,
            'kode_jam'      => $request->kode_jam
        ]);
        if ($post) {
            return response()->json([
                'status'  => true,
                'message' => 'Data Updated',
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Data Failed to Update'
            ], 404);
        }
    }

    public function destroy($kode)
    {
        $post = DB::table('waktu_tidak_bersedia')
            ->where('kode', $kode)->delete();
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Data Deleted',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Data Not Found',
        ], 404);
    }
}
