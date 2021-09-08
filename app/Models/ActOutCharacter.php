<?php
/**
 * Class ActOutCharacter
 * Created by nguyendx.
 * Date: 8/26/21
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActOutCharacter extends Model
{
    use HasFactory;

    protected $table = 'act_out_character';

    protected $fillable = [
        'lesson_id',
        'characterId ',
        'characterName ',
        'image '
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'lesson_id' => 0,
        'characterId' => 0,
        'characterName' => '',
        'image' => '',
    ];
}
