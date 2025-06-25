<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PendaftaranEvent extends Model
{
    use HasFactory;

    protected $table = 'pendaftaran_event';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'event_id',
        'user_id',
        'status_pembayaran',
        'qr_code',
        'bukti_bayar',
        'created_at',
    ];

    protected $casts = [
    'created_at' => 'datetime',
    ];


    // Relasi ke event
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kehadirans()
    {
        return $this->hasMany(Kehadiran::class, 'pendaftaran_event_id');
    }

    public function kehadiran()
    {
        return $this->hasOne(Kehadiran::class, 'pendaftaran_event_id');
    }


}
