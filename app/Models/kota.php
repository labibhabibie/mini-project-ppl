<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kota extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public function provinsi(){
        return $this->belongsTo(Provinsi::class);
}
public function mahasiswa(){
    return $this->hasMany(Mahasiswa::class);
}
}
