<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vocabulary extends Model
{
    use HasFactory;

    protected $table = 'vocabulary';

    protected $fillable = [
        'name', 'spelling', 'thumb', 'description', 'status', 'created_by', 'updated_by'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'spelling' => '',
        'thumb' => '',
        'description' => '',
        'status' => 1,
        'created_by' => 1,
        'updated_by' => 1,
    ];
}
