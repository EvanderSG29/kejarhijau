<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['id_user', 'tanggal', 'jenis_sampah', 'jumlah', 'satuan', 'tujuan_akhir'])]
class LaporanHarianSampah extends Model
{
    protected $table = 'laporan_harian_sampah';

    protected $primaryKey = 'id_laporan_harian_sampah';

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'jenis_sampah' => 'boolean',
            'jumlah' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
