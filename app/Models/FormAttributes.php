<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormAttributes extends Model
{
    use HasFactory;

    protected $table = 'form_attributes';
    protected $primaryKey = 'id';
    protected $guarded = ['id'];

    public static function FieldType()
    {
        return [
            'text' => 'Text',
            'number' => 'Number',
            'select' => 'Select'
        ];
    }

    public function getFieldAttributes()
    {
        return $this->hasMany('App\Models\FieldAttributes', 'id_form_attributes', 'id');
    }
}
