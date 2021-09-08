<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Levels;

class Course extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'courses';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'level_id',
        'thumb_img',
        'created_by',
        'updated_by',
    ];

    protected $attributes = [
        'status' => 1,
        'created_by' => 1,
        'updated_by' => 1,
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hasLevel()
    {
        return $this->belongsTo(Levels::class, 'level_id', 'id');
    }
}
