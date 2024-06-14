<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    use HasFactory;

    protected $table = 'forms';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public function getFormAttributes()
    {
        return $this->hasMany('App\Models\FormAttributes', 'id_forms', 'id');
    }
}
