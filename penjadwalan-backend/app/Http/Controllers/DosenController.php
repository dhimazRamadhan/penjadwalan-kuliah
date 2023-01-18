<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    public function index()
    {
        //get data from table dosen
        $post = Dosen::get();
        //make response JSON
        return response()->json([
            'success' => true,
            'count' => count($post),
            'message' => 'List Data Dosen',
            'data'    => $post
        ], 200);
    }

    public function show($kode)
    {
        // $post = Dosen::get($id);
        $post = DB::table('dosen')
            ->where('kode', $kode)->get();
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Dosen',
            'data'    => $post
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nidn'      => 'required',
            'nama'      => 'required',
            'alamat'    => 'required',
            'telp'      => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $post = Dosen::create([
            'nidn'      => $request->nidn,
            'nama'      => $request->nama,
            'alamat'    => $request->alamat,
            'telp'      => $request->telp,
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
        $validator = Validator::make($request->all(), [
            'nidn'      => 'required',
            'nama'      => 'required',
            'alamat'    => 'required',
            'telp'      => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }
        $post = Dosen::where('kode', $kode)->update([
            'nidn'    => $request->nidn,
            'nama'    => $request->nama,
            'alamat'  => $request->alamat,
            'telp'    => $request->telp,
        ]);
        if ($post) {
            return response()->json([
                'status'  => true,
                'message' => 'Dosen Updated',
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Dosen Failed to Update'
            ], 404);
        }
    }

    public function destroy($kode)
    {
        //find post by ID
        $post = DB::table('dosen')
            ->where('kode', $kode)->delete();
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Data Deleted',
            ], 200);
        }
        //data post not found
        return response()->json([
            'success' => false,
            'message' => 'Data Not Found',
        ], 404);
    }

    public function dosenView()
    {
        $post = DB::select('SELECT a.kode as "kode_dosen",
		a.nama as "dosen",
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
        join hari d on f.kode_hari = d.kode
        join jam e on f.kode_jam = e.kode');

        return response()->json([
            'success' => true,
            'message' => 'List Data',
            'count' => count($post),
            'data'    => $post
        ]);
    }
}
