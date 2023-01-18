<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadkul extends Model
{
    use HasFactory;
    protected $table = 'jadwalkuliah';
    /**
     * fillable
     * 
     * @var array
     */
    protected $fillable = [
        'kode_pengampu', 'kode_jam', 'kode_hari', 'kode_ruang'
    ];
}
