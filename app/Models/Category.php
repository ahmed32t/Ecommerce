<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=["user_id","parent_id","name","slug",
     'category_id',"photo","description","price",'small_descripe','special_name','details'
,'sale'];
    protected $dates=['deleted_at'];
    protected $table= 'subcategories_products';
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(parrentcategory::class,'category_id', 'id')->withTrashed();
    }
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withTrashed();
    }

    public function product(): HasMany
    {
           return $this->hasMany(Category::class, 'parent_id', 'id')->withTrashed();
    }



}
