<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImages extends Model{

    protected $table = 'products_images';

	protected $fillable = ['product_id', 'image'];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
       return $this->belongsTo(Product::class);
    }
}
