<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Levels extends Model
{
    use HasFactory;

    protected $table = 'levels';

    protected $fillable = [
        'name', 'status', 'created_by', 'updated_by'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => "",
        'status' => 1,
        'created_by' => 1,
        'updated_by' => 1,
    ];
}
