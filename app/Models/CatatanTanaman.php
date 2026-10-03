<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['id_user', 'nama_tanaman', 'jenis_tanaman', 'lokasi_tanaman', 'cara_merawat', 'foto_tanaman'])]
class CatatanTanaman extends Model
{
    protected $table = 'catatan_tanaman';

    protected $primaryKey = 'id_catatan_tanaman';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
