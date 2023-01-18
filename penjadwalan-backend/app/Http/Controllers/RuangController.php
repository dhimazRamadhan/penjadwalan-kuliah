<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ruang;
use Illuminate\Support\Facades\DB;

class RuangController extends Controller
{
    public function index()
    {
        //get data from table dosen
        $post = Ruang::get();
        //make response JSON
        return response()->json([
            'success' => true,
            'count' => count($post),
            'message' => 'List Data Mata Ruang',
            'data'    => $post
        ], 200);
    }

    public function show($kode)
    {
        //find post by ID
        $post = DB::table('ruang')
            ->where('kode', $kode)
            ->get();
        //make response JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Ruang',
            'data'    => $post
        ], 200);
    }

    public function store(Request $request)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'kapasitas'  => 'required',
            'jenis'     => 'required',
        ]);
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        //save to database
        $post = Ruang::create([
            'nama'        => $request->nama,
            'kapasitas'   => $request->kapasitas,
            'jenis'       => $request->jenis
        ]);
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Ruang Created',
                'data'    => $post
            ], 201);
        }
        //failed save to database
        return response()->json([
            'success' => false,
            'message' => 'Ruang Failed to Save',
        ], 409);
    }

    public function update(Request $request, $kode)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama'      => 'required',
            'kapasitas'  => 'required',
            'jenis'     => 'required'
        ]);

        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }
        $post = Ruang::where('kode', $kode)->update([
            'nama'        => $request->nama,
            'kapasitas'   => $request->kapasitas,
            'jenis'       => $request->jenis
        ]);
        if ($post) {
            return response()->json([
                'status'  => true,
                'message' => 'Ruang Updated',
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Ruang Failed to Update'
            ], 404);
        }
    }

    public function destroy($kode)
    {
        //find post by ID
        $post = DB::table('ruang')
            ->where('kode', $kode)
            ->delete();
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Ruang Deleted',
            ], 200);
        }
        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Ruang Not Found',
        ], 404);
    }

    public function ruangView()
    {
        $post = DB::select('SELECT a.kode as "kode_dosen",
		g.kode as "kode_ruang",
        g.nama as "nama_ruang",
        c.kode as "kode_matakuliah",
        c.nama as "matakuliah",
        CONCAT (c.kode_mk, " / ", b.kelas) as "kode_mk",
        d.kode as "kode_hari",
        d.nama as "hari",
        e.kode as "kode_jam",
        e.range_jam as "jam"
        from dosen a
        join pengampu b on b.kode_dosen = a.kode
        join matakuliah c on c.kode = b.kode_mk
        join jadwalkuliah f on b.kode = f.kode_pengampu
        join ruang g on f.kode_ruang = g.kode
        join hari d on f.kode_hari = d.kode
        join jam e on f.kode_jam = e.kode;');

        return response()->json([
            'success' => true,
            'message' => 'List Data',
            'count' => count($post),
            'data'    => $post
        ]);
    }
}
