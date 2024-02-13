<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
	protected $fillable = ['name', 'image'];

    /**
     * @return BelongsToMany
     */
    public function products(): BelongsToMany
    {
       return $this->belongsToMany('App\Models\Product', 'products_categories');
    }
}
