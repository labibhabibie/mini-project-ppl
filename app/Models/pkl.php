<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pkl extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // public function mahasiswa(){
    //     return $this->belongsTo(Mahasiswa::class);
    // }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
