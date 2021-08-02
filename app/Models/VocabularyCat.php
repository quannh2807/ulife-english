<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VocabularyCat extends Model
{
    use HasFactory;

    protected $table = 'vocabulary_cat';

    protected $fillable = [
        'name', 'thumb', 'parent_id', 'description', 'type', 'status', 'created_by', 'updated_by'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'name' => '',
        'thumb' => '',
        'parent_id' => 0,
        'description' => '',
        'type' => 1,
        'status' => 1,
        'created_by' => 1,
        'updated_by' => 1,
    ];
}
