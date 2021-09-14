<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'languages';

    /**
     * @var string[]
     */
    protected $fillable = [
        'type',
        'name',
        'key',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'created_by' => 0,
        'updated_by' => 0,
    ];
}
