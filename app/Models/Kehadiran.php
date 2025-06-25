<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kehadiran extends Model
{
    use HasFactory;

    protected $table = 'kehadiran';
    public $timestamps = false;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'users_id',
        'pendaftaran_event_id',
        'event_id',
        'waktu_kehadiran',
    ];

    protected $casts = [
        'waktu_kehadiran' => 'datetime',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    // Relasi ke Pendaftaran Event
    public function pendaftaranEvent()
    {
        return $this->belongsTo(PendaftaranEvent::class, 'pendaftaran_event_id');
    }

    // Relasi ke Event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class, 'kehadiran_id');
    }

}
