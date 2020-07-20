<?php

namespace App\Repositories;

use App\Branch;
use App\Http\Requests\FavoriteStoreRequest;
use App\Http\Resources\BranchResource;

class FavoriteRepository implements FavoriteRepositoryInterface
{
    public function userBranchFavorites()
    {
        $favorites = auth()->user()
            ->favoriteBranches()
            ->where('model', 'App\Branch')
            ->paginate(15);

        return BranchResource::collection($favorites);
    }

    public function storeBranchFavorite(FavoriteStoreRequest $request)
    {
        $favorite = auth()->user()
            ->favoriteBranches();

        if (! $favorite->get()->contains($request->branch_id)) {
            $favorite->attach(
                [$request->branch_id],
                ['model' => 'App\Branch']
            );
        } else {
            $favorite->detach($request->branch_id);
        }

        return BranchResource::collection(
            auth()->user()
                ->favoriteBranches()
                ->paginate()
        );
    }
}
