<?php
namespace App\Repositories;

use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    /**
     * @param Product       $productModel
     * @param ProductImages $productImagesModel
     */
    public function __construct(
        protected Product $productModel,
        protected ProductImages $productImagesModel
    ) {
    }

    /**
     * @param  int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->productModel::with('images')->find($id);
    }

    /**
     * @param  int $qty
     * @return mixed
     */
    public function findPaginate(int $qty): mixed
    {
        return $this->productModel::where('active', 1)->paginate($qty);
    }

    /**
     * @return Collection
     */
    public function findAll(): Collection
    {
        return $this->productModel::where('active', 1)->get();
    }

    /**
     * @param  array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->productModel::create($data);
    }

    /**
     * @param  array $data
     * @return Model
     */
    public function createImage(array $data): Model
    {
        return $this->productImagesModel::create($data);
    }

    /**
     * @param  string|null $name
     * @param  array|null  $categories
     * @return Collection
     */
    public function search(?string $name, ?array $categories): Collection
    {
        $query = DB::table('products')
            ->select('products.id', 'products.name', 'products.description')
            ->where('products.active', '=', 1)
            ->join('products_categories', 'products.id', '=', 'products_categories.product_id')
            ->join('categories', 'products_categories.category_id', '=', 'categories.id')
            ->groupBy('products.id', 'products.name', 'products.description');

        if (!empty($name)) {
            $query->where('products.name', 'like', '%' . $name . '%');
        }

        if (!empty($categories)) {
            $query->whereIn('categories.id', $categories);
        }

        return $query->get();
    }
}
