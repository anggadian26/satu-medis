<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtikeModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';

    protected $guarded = [];
}
