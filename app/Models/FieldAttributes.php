<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldAttributes extends Model
{
    use HasFactory;

    protected $table = 'field_attributes';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];
}
