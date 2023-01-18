<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengampu extends Model
{
    use HasFactory;
    protected $table = 'pengampu';
    /**
     * fillable
     * 
     * @var array
     */
    protected $fillable = [
        'kode_mk', 'kode_dosen', 'kelas', 'tahun_akademik'
    ];
}
