<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\IExampleRepository;

class ExampleController extends Controller
{

    private IExampleRepository $exampleRepository;

    public function __construct(IExampleRepository $exampleRepository) {
        $this->exampleRepository = $exampleRepository;
    }

    public function index()
    {
        return $this->exampleRepository->getAll();
    }
}
