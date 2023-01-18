<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Pengampu;

class PengampuController extends Controller
{
    public function index()
    {
        $post = DB::select('SELECT a.kode as "kode",
        b.nama as "matakuliah",
        c.nama as "dosen",
        a.kelas as "kelas",
        a.tahun_akademik as "tahun_akademik"
        from pengampu a 
        join matakuliah b on a.kode_mk = b.kode
        join dosen c on a.kode_dosen = c.kode');

        // make response JSON
        return response()->json([
            'success' => true,
            'count' => count($post),
            'message' => 'List Data',
            'data'    => $post
        ], 200);
    }

    public function show($kode)
    {
        //find post by ID
        $post = DB::table('pengampu')
            ->where('kode', $kode)
            ->get();
        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Pegampu',
            'data'    => $post
        ], 200);
    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'kode_mk'          => 'required',
            'kode_dosen'       => 'required',
            'kelas'            => 'required',
            'tahun_akademik'   => 'required',
        ]);
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        //save to database
        $post = Pengampu::create([
            'kode_mk'          => $request->kode_mk,
            'kode_dosen'       => $request->kode_dosen,
            'kelas'            => $request->kelas,
            'tahun_akademik'   => $request->tahun_akademik
        ]);
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Pengampu Created',
                'data'    => $post
            ], 201);
        }
        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Pengampu Failed to Save',
        ], 409);
    }

    public function update(Request $request, $kode)
    {
        $validator = Validator::make($request->all(), [
            'kode_mk'          => 'required',
            'kode_dosen'       => 'required',
            'kelas'            => 'required',
            'tahun_akademik'   => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }
        $post = Pengampu::where('kode', $kode)->update([
            'kode_mk'          => $request->kode_mk,
            'kode_dosen'       => $request->kode_dosen,
            'kelas'            => $request->kelas,
            'tahun_akademik'   => $request->tahun_akademik
        ]);
        if ($post) {
            return response()->json([
                'status'  => true,
                'message' => 'Pengampu Updated',
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Pengampu Failed to Update'
            ], 404);
        }
    }

    public function destroy($kode)
    {
        //find post by ID
        $post = DB::table('pengampu')
            ->where('kode', $kode)
            ->delete();
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Pengampu Deleted',
            ], 200);
        }
        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Pengampu Not Found',
        ], 404);
    }
}
