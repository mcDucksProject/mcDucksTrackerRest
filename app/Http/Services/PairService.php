<?php

namespace App\Http\Services;

use App\Exceptions\DeleteException;
use App\Exceptions\SaveException;
use App\Models\Pair;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class PairService
{
    /**
     * @throws SaveException
     */
    function create($quoteId, $baseId): Pair
    {
        try {
            $pair = new Pair();
            $pair->base_id = $baseId;
            $pair->quote_id = $quoteId;
            $pair->saveOrFail();
        } catch (Throwable $e) {
            throw new SaveException();
        }
        return $pair;
    }

    /**
     * @throws DeleteException
     */
    function delete($pairId)
    {
        try {
            Pair::findOrFail($pairId)->deleteOrFail();
        } catch (ModelNotFoundException | Throwable $e) {
            throw new DeleteException();
        }
    }

    function getById($pairId): Pair
    {
        return Pair::findOrFail($pairId);
    }

    function getByBase($baseId): Collection
    {
        return Pair::whereBaseId($baseId)->get();
    }

    function getByQuote($quoteId): Collection
    {
        return Pair::whereQuoteId($quoteId)->get();
    }
}
