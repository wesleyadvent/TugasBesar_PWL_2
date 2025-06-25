<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'event';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'nama',
        'lokasi',
        'narasumber',
        'tanggal',
        'waktu',
        'waktu_selesai',
        'poster',
        'biaya',
        'jumlah_peserta',
        'users_id',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function pendaftarans()
    {
        return $this->hasMany(PendaftaranEvent::class, 'event_id');
    }

    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class, 'event_id');
    }

}
