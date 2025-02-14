<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Budget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaksi extends Model
{
    use HasFactory;

    protected $connection = 'anggaran';
    protected $table = 'transaksi';
    protected $fillable = [
        'user_id',
        'budget_id',
        'tanggal',
        'kegiatan',
        'jumlah_nominal',
        'no_dokumen',
        'file_dokumen',
        'uraian',
        'approval',
        'outstanding',
    ];

    /**
     * Method relasi one to many dengan table user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Method relasi one to many dengan table jenis_belanja
     */
    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_id', 'id');
    }

    /**
     * Merubah format created_at
     */
    public function getCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['created_at'])->format('d M Y H:i');
    }

    /**
     * Merubah format updated_at
     */
    public function getUpdatedAtAttribute()
    {
        return Carbon::parse($this->attributes['updated_at'])->format('d M Y H:i');
    }
}
