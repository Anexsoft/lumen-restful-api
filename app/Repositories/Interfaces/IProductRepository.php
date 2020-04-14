<?php
namespace App\Repositories\Interfaces;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\Paginator;
use App\DTOs\Products\ProductCreateDto;
use App\DTOs\Products\ProductUpdateDto;

interface IProductRepository
{
    public function paginate(int $take): Paginator;
    public function find(int $id): ?Product;
    public function store(ProductCreateDto $store): Product;
    public function update(ProductUpdateDto $store): void;
    public function image(int $id, UploadedFile $file): void;
    public function destroy(int $id): void;
}
