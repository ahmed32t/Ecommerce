<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class parrentcategory extends Model
{
use HasFactory,SoftDeletes;

protected $fillable=["user_id","name","slug",
       "photo","description",'small_descripe','special_name','sale'];

protected $dates=['deleted_at'];
protected $table= 'parrentcategories';

public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}

public function subcategory(): HasMany
{
    return $this->hasMany(Category::class,'category_id', 'id')->withTrashed();
}


}
