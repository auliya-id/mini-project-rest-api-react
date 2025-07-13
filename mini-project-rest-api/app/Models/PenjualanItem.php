<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanItem extends Model
{
    use HasFactory;

    protected $table = 'penjualan_item';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function barang() { 
        return $this->belongsTo(Barang::class, 'id_barang'); 
    }
}
