<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'categories';

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'slug', 'position', 'parent_id', 'type', 'status', 'created_by', 'updated_by'
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'position' => 1,
        'parent_id' => 0,
        'type' => 1,
        'created_by' => 1,
        'updated_by' => 1,
    ];

    /**
     * @return BelongsTo
     * children -> parent
     */
    public function hasParentCate()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     * parent -> children
     */
    public function hasChildrenCate()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function hasChildrenCateRecursive()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->with('hasChildrenCate');
    }
}
