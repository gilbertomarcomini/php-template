<?php
namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class CategoryService
{
    const IMAGE_PATH = 'images/category';

    public function __construct(
        protected CategoryRepository $categoryRepository
    ) {
    }

    /**
     * @param int $qty
     * @return mixed
     */
    public function findPaginate(int $qty): mixed
    {
        return $this->categoryRepository->findPaginate($qty);
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * @return Collection
     */
    public function findAll(): Collection
    {
        return $this->categoryRepository->findAll();
    }

    /**
     * @param array $data
     * @return Model|null
     */
    public function create(array $data): ?Model
    {
        $name = Arr::get($data, 'name');
        $image = Arr::get($data, 'image');

        $fileName = FileService::move($image, self::IMAGE_PATH);
        if (!is_null($fileName)) {
            return $this->categoryRepository->create([
                'name' => $name,
                'image' => $fileName,
            ]);
        }
    }

    /**
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        $category = $this->categoryRepository->find($id);
        if (!empty($category)) {
            $newName = Arr::get($data, 'name');
            $newImage = Arr::get($data, 'image');
            $deletedImage = Arr::get($data, 'deleted_image');
            $update = [
                'name' => $newName
            ];
            if (!empty($newImage)) {
                $fileName = FileService::move($newImage, self::IMAGE_PATH);
                $update['image'] = $fileName;
                FileService::delete($deletedImage, self::IMAGE_PATH);
            }
            return $category->update($update);
        }
        return false;
    }

    /**
     * @param int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool
    {
        $category = $this->categoryRepository->find($id);

        if (!empty($category)) {
            FileService::delete($category->image, self::IMAGE_PATH);
            $category->products()->detach();
            return $category->delete();
        }
        return false;
    }

    /**
     * @param string|null $name
     * @return Collection
     */
    public function search(?string $name): Collection
    {
        return $this->categoryRepository->search($name);
    }
}
