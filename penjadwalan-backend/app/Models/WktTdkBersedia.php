<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WktTdkBersedia extends Model
{

    use HasFactory;
    protected $table = 'waktu_tidak_bersedia';
    /**
     * fillable
     * 
     * @var array
     */
    protected $fillable = [
        'kode_dosen', 'kode_hari', 'kode_jam'
    ];
}
