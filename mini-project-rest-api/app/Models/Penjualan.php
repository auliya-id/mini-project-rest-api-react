<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'penjualan';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = [];

    public function pelanggan() { 
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan'); 
    }

    public function items() { 
        return $this->hasMany(PenjualanItem::class, 'id_penjualan')->with('barang');
    }

}