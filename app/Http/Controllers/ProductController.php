<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\DTOs\Products\ProductCreateDto;
use App\DTOs\Products\ProductUpdateDto;
use App\Repositories\Interfaces\IProductRepository;

class ProductController extends Controller
{
    private IProductRepository $productRepository;

    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        return $this->productRepository->paginate(20);
    }

    public function show(int $id)
    {
        $result = $this->productRepository->find($id);

        if($result) {
            return $result;
        }

        return response('Product not found', 404);
    }

    public function store(Request $request)
    {
        // Validation
        $this->validate($request, [
            'sku' => 'required|unique:products',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:1'
        ]);

        // Mapping
        $store = new ProductCreateDto($request->all());

        // Creation
        $result = $this->productRepository->store($store);

        return response($result, 201);
    }

    public function update(int $id, Request $request)
    {
        // Validation
        $this->validate($request, [
            'sku' => [
                'required',
                Rule::unique('products')->ignore($id)
            ],
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|min:1'
        ]);

        // Mapping
        $data = $request->all();
        $data['id'] = $id;

        $entry = new ProductUpdateDto($data);

        // Update
        $this->productRepository->update($entry);

        return response(null, 204);
    }

    public function image(int $id, Request $request)
    {
        // Validation
        $this->validate($request, [
            'image' => 'mimes:jpeg,png,bmp,tiff'
        ]);

        $this->productRepository->image(
            $id,
            $request->file('image')
        );

        return response(null, 204);
    }

    public function destroy(int $id)
    {
        $this->productRepository->destroy($id);
        return response(null, 204);
    }
}
