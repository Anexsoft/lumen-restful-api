<?php
namespace App\Repositories;

use Exception;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use App\DTOs\Products\ProductCreateDto;
use App\DTOs\Products\ProductUpdateDto;
use App\Repositories\Interfaces\IProductRepository;

class ProductRepository implements IProductRepository
{
    public function paginate(int $take): Paginator
    {
        return Product::orderBy('name')
        //   ->where('price', '>=', 80)
        //   ->where('price', '<=', 100)
            ->whereBetween('price', [80, 100])
            ->simplePaginate($take);
    }

    public function find(int $id): ?Product
    {
        return Product::find($id);
    }

    public function store(ProductCreateDto $store): Product
    {
        $entry = new Product();

        $entry->sku = $store->sku;
        $entry->name = $store->name;
        $entry->description = $store->description;
        $entry->price = $store->price;

        $entry->save();

        return $entry;
    }

    public function update(ProductUpdateDto $store): void
    {
        $entry = Product::find($store->id);

        $entry->sku = $store->sku;
        $entry->name = $store->name;
        $entry->description = $store->description;
        $entry->price = $store->price;

        $entry->save();
    }

    public function image(int $id, UploadedFile $file): void
    {
        $entry = Product::find($id);

        if ($entry) {
            // filename
            $filename = Str::random(20) . '.' . $file->getClientOriginalExtension();

            // path
            $path = app()->basePath('public/images/');

            // upload
            $file->move($path, $filename);

            $entry->image = URL::to('images/' . $filename);

            // save changes
            $entry->save();
        } else {
            throw new Exception("Entry wasn't found by " . $id);
        }
    }

    public function destroy(int $id): void
    {
        Product::destroy($id);
    }
}
