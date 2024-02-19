<?php
namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CategoryRepository
{
    /**
     * @param Category $categoryModel
     */
    public function __construct(
        protected Category $categoryModel
    ) {
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->categoryModel::find($id);
    }

    /**
     * @param int $qty
     * @return mixed
     */
    public function findPaginate(int $qty): mixed
    {
        return $this->categoryModel::where('active', 1)->paginate($qty);
    }

    /**
     * @return Collection
     */
    public function findAll(): Collection
    {
        return $this->categoryModel::where('active', 1)->get();
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->categoryModel::create($data);
    }

    /**
     * @param string|null $name
     * @return Collection
     */
    public function search(?string $name): Collection
    {
        return $this->categoryModel::where('name', 'like', '%' . $name . '%')
            ->where('active', 1)
            ->get();
    }
}
