<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $transactionRepository;
    private $userRepository;

    public function __construct(TransactionRepository $transactionRepository, UserRepository $userRepository)
    {
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        if (!$request->hasHeader('Authorization')) {
            abort(403);
        }

        $user = $this->userRepository->getByAPIKey($request->header('Authorization'));

        if (!$user) {
            abort(403);
        }

        if (!count($user->spaces)) {
            return [];
        }

        return $this->transactionRepository->getBySpaceId($user->spaces[0]->id);
    }
}
