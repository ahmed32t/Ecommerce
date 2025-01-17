<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewCategory extends Model
{
    use HasFactory,SoftDeletes;
    protected $dates=['deleted_at'];
    protected $table = 'newcategories';

    protected $fillable=["numberofcategories",'newcategory','time','user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
