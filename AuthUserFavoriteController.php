<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\FavoriteStoreRequest;
use App\Repositories\FavoriteRepositoryInterface;
use Illuminate\Http\Request;

class AuthUserFavoriteController extends Controller
{
    /**
     * @var FavoriteRepositoryInterface
     */
    private $favoriteRepository;

    public function __construct(FavoriteRepositoryInterface $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function index()
    {
        return $this->favoriteRepository->userBranchFavorites();
    }

    public function store(FavoriteStoreRequest $request)
    {
        return $this->favoriteRepository->storeBranchFavorite($request);
    }
}
