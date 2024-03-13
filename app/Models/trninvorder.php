<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class trninvorder extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'ID';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'trninvorder';
    protected $fillable = ['BUKTI', 'PERIODE', 'TANGGAL','JTHTEMPO', 'TGLKIRIM','SUPPLIER', 'NOMORPO', 'MATAUANG', 'KURS', 'PEMBELIAN', 'DISCOUNT', 'NETTO', 'KETERANGAN', 'TGLEDIT', 'TGLENTRY', 'USEREDIT', 'USERENTRY'];
    protected $casts = [
        'TGLENTRY' => 'datetime',
        'TGLEDIT' => 'datetime',
    ];

    public function dtlinvorder()
    {
        return $this->hasMany(dtlinvorder::class, 'BUKTI', 'BUKTI')
            ->whereColumn('dtlinvorder.PERIODE', 'trninvorder.PERIODE');
    }

    public function supplier()
    {
        return $this->belongsTo(supplier::class,'ID_SUPPLIER','ID_SUPPLIER');
    }
}
