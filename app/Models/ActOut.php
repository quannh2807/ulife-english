<?php
/**
 * Class ActOut
 * Created by nguyendx.
 * Date: 8/24/21
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActOut extends Model
{
    use HasFactory;

    protected $table = 'act_out';

    protected $fillable = [
        'lesson_id',
        'time_start',
        'time_end',
        'en',
        'vi',
        'user_tag',
        'status',
        'created_by',
        'updated_by'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'lesson_id' => '',
        'time_start' => '',
        'time_end' => '',
        'en' => '',
        'vi' => '',
        'user_tag' => '',
        'status' => 1,
        'created_by' => 1,
        'updated_by' => 1,
    ];

}
