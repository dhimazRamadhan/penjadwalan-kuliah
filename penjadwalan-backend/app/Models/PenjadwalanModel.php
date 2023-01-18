<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Jam;
use App\Models\Hari;
use App\Models\WktTdkBersedia;
use App\Models\Jadkul;
use App\Models\Ruang;
use  App\Models\Pengampu;
use App\Models\Matkul;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;

use function Psy\debug;

class PenjadwalanModel extends Model

{
    public function __construct()
    {
    }

    public function GetKelas($semester, $tahun_akademik)
    {
        $result = DB::select('SELECT
                a.kode, 
                b.sks, 
                a.kode_dosen, 
                b.jenis
                FROM pengampu a
                LEFT JOIN matakuliah b ON a.kode_mk = b.kode
                WHERE b.semester % 2 = :semester
                AND a.tahun_akademik = :tahun', ["semester" => $semester, "tahun" => $tahun_akademik]);
        return $result;
    }

    function GetJam()
    {
        $result = DB::table('jam')
            ->select('kode')
            ->get();
        return $result;
    }

    function GetHari()
    {
        $result = DB::table('hari')
            ->select('kode')
            ->get();
        return $result;
    }

    function GetRuang($param)
    {
        $result = DB::table('ruang')
            ->select('kode')
            ->where('jenis', '=', $param)
            ->get();
        return $result;
    }

    function GetTimeOffDosen()
    {
        $result = DB::table('waktu_tidak_bersedia')
            ->select('kode_dosen', DB::raw('CONCAT_WS(\':\', kode_hari, kode_jam) AS kode_hari_jam'))
            ->get();
        return $result;
    }

    function KosongkanJadwal()
    {
        $result = Jadkul::truncate();
        return $result;
    }

    function InsertJadwal($kode_pengampu, $kode_jam, $kode_hari, $kode_ruang)
    {
        // $request = new \Illuminate\Http\Request();
        $result = DB::table('jadwalkuliah')->insert([
            'kode_pengampu'  => $kode_pengampu,
            'kode_jam'       => $kode_jam,
            'kode_hari'      => $kode_hari,
            'kode_ruang'     => $kode_ruang
        ]);
        return $result;
    }

    function GetSks($param)
    {
        $result = DB::select('SELECT a.kode AS kode_pengampu, b.sks
        from pengampu a 
        join matakuliah b ON a.kode_mk = b.kode where a.kode = :kode', ["kode" => $param]);
        return $result;
    }

    function GetJadwal()
    {
        $result = DB::select("SELECT e.nama AS hari,
            CONCAT('(',g.kode, '-', g.kode + c.sks - 1,')') AS sesi, 
            CONCAT_WS('-', MID(g.range_jam,1,5), (SELECT MID(range_jam,7,5) 
            FROM jam WHERE kode = g.kode + c.sks - 1)) 
            AS jam_kuliah, c.nama AS nama_mk, c.sks AS sks, c.semester AS semester, b.kelas AS kelas, d.nama AS dosen, f.nama AS ruang 
            FROM jadwalkuliah a LEFT JOIN pengampu b ON a.kode_pengampu = b.kode LEFT JOIN matakuliah c ON b.kode_mk = c.kode 
            LEFT JOIN dosen d ON b.kode_dosen = d.kode LEFT JOIN hari e ON a.kode_hari = e.kode LEFT JOIN ruang f ON a.kode_ruang = f.kode 
            LEFT JOIN jam g ON a.kode_jam = g.kode ORDER BY e.kode ASC, Jam_Kuliah ASC");
        return $result;
    }
}
