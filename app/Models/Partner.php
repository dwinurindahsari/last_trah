<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $table = 'pasangan';

    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'urutan_anak',
        'status_kehidupan',
        'anggota_keluarga_id', // FK ke anggota_keluarga
        'photo', 
    ];

    // Relasi balik ke AnggotaKeluarga
    public function anggotaKeluarga()
    {
        return $this->belongsTo(Anggota_Keluarga::class, 'anggota_keluarga_id');
    }
}