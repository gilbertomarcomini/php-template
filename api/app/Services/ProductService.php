<?php
namespace App\Services;

use App\Enums\ImagePath;
use App\Repositories\ProductRepository;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Throwable;

class ProductService
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {
    }

    /**
     * @param  int $id
     * @return Model|null
     */
    public function find(int $id): ?Model
    {
        return $this->productRepository
            ->find($id);
    }

    /**
     * @param  int $qty
     * @return mixed
     */
    public function findPaginate(int $qty): mixed
    {
        return $this->productRepository->findPaginate($qty);
    }

    /**
     * @return Collection
     */
    public function findAll(): Collection
    {
        return $this->productRepository->findAll();
    }

    /**
     * @param  array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        $images = Arr::get($data, 'images', []);
        $categories = Arr::get($data, 'categories');
        $name = Arr::get($data, 'name');
        $description = Arr::get($data, 'description');
        $descriptionAPI = $this->getDescription();
        if (!is_null($descriptionAPI)) {
            $description = $descriptionAPI;
        }
        $product = $this->productRepository->create([
            'name' => $name,
            'description' => $description
        ]);
        $product->categories()->sync($categories);
        foreach ($images as $image) {
            $this->createProductImage($image, $product->id);
        }
        return $product;
    }

    /**
     * @param  int   $id
     * @param  array $data
     * @return Model
     */
    public function update(int $id, array $data): Model
    {
        $product = $this->productRepository->find($id);
        $images = Arr::get($data, 'images', []);
        $categories = Arr::get($data, 'categories');
        if (!empty($product)) {
            foreach ($images as $image) {
                $this->createProductImage($image, $product->id);
            }
            $product->categories()->sync($categories);
            $product->update([
                'name' =>  Arr::get($data, 'name'),
                'description' => Arr::get($data, 'description')
            ]);
        }
        return $product;
    }

    /**
     * @param  int $id
     * @return bool|null
     */
    public function delete(int $id): ?bool
    {
        $product = $this->productRepository->find($id);

        if (!empty($product)) {
            if (!empty($product->images)) {
                foreach ($product->images as $image) {
                    FileService::delete($image->image, ImagePath::PRODUCT->value);
                }
            }
            $product->categories()->detach();
            $product->images()->delete();
            return $product->delete();
        }

        return false;
    }

    /**
     * @param  string|null $name
     * @param  array|null  $categories
     * @return Collection
     */
    public function search(?string $name, ?array $categories): Collection
    {
        return $this->productRepository->search($name, $categories);
    }

    /**
     * @param  $image
     * @param  int $productId
     * @return void
     */
    private function createProductImage($image, int $productId): void
    {
        $fileName = FileService::move($image, ImagePath::PRODUCT->value);
        $this->productRepository->createImage([
            'product_id' => $productId,
            'image' => $fileName
        ]);
    }

    /**
     * @return mixed|null
     */
    private function getDescription(): mixed
    {
        $client = app(Client::class, [
            'config' => [
                'verify'          => false,
                'http_errors'     => false,
                'allow_redirects' => true,
                'headers'         => [
                    'Accept'          => 'application/json',
                    'Content-Type'    => 'application/json',
                    'Accept-Encoding' => 'gzip',
                ],
            ],
        ]);
        try {
            $response = $client->request('GET', 'https://0f1d1f20265a4e5bbab0db3a63b996b0.api.mockbin.io');
            if ($response->getStatusCode() === 200) {
                $json = json_decode($response->getBody()->getContents(), true);
                return Arr::get($json, 'description');
            }
            throw new HttpClientException($response->getBody()->getContents());
        } catch (Throwable) {
            return null;
        }
    }
}
