<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $table = 'budget';
    protected $fillable = [
        'jenis_belanja_id',
        'tahun_anggaran',
        'nominal',
        'keterangan'
    ];

    /**
     * Method relasi one to many dengan table jenis_belanja
     *
     * @return object
     */
    public function jenisBelanja(): object
    {
        return $this->belongsTo(JenisBelanja::class, 'jenis_belanja_id', 'id');
    }

    /**
     * Merubah format created_at
     */
    public function getCreatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['created_at'])->format('d M Y H:i');
    }

    /**
     * Merubah format updated_at
     */
    public function getUpdatedAtAttribute()
    {
        return \Carbon\Carbon::parse($this->attributes['updated_at'])->format('d M Y H:i');
    }
}
