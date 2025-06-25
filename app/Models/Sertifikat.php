<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sertifikat extends Model
{
    use HasFactory;

    protected $table = 'sertifikat';
    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'kehadiran_id',
        'file_sertifikat',
        'uploaded_at',
    ];

    public function kehadiran()
    {
        return $this->belongsTo(Kehadiran::class, 'kehadiran_id');
    }
}
