<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\IIdentityRepository;
use App\Repositories\Exceptions\AccessDeniedException;

class IdentityController extends Controller
{
    private IIdentityRepository $identityRepository;

    public function __construct(IIdentityRepository $identityRepository)
    {
        $this->identityRepository = $identityRepository;
    }
    
    public function signin(Request $request)
    {
        try {
            return response()->json(
                $this->identityRepository->signin(
                    $request->input('email'),
                    $request->input('password')
                )
            );
        } catch (AccessDeniedException $ex) {
            return response($ex->getMessage(), 400);
        }
    }

    public function test() 
    {
        return Auth::user();
    }
}
