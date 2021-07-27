<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    use HasFactory;

    protected $table = 'topics';

    protected $fillable = [
        'id', 'level_id', 'name', 'status', 'created_by', 'updated_by'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'level_id' => 0,
        'name' => '',
        'status' => 1,
        'created_by' => 1,
        'updated_by' => 1,
    ];

    public function hasLevel()
    {
        return $this->belongsTo(Levels::class, 'level_id', 'id');
    }
}
