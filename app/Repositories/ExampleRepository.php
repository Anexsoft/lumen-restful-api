<?php
namespace App\Repositories;

use App\Repositories\Interfaces\IExampleRepository;

class ExampleRepository implements IExampleRepository
{
    public function getAll()
    {
        return ['banana', 'orange', 'pear'];
    }
}
