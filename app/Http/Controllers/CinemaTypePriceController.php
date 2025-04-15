<?php

namespace App\Http\Controllers;

use App\Models\CinemaTypePrice;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CinemaTypePriceController extends Controller
{
    /**
     * Display a listing of the cinema type prices.
     */
    public function index()
    {
        $prices = CinemaTypePrice::all();

        return response()->json(['data' => $prices], Response::HTTP_OK);
    }

    /**
     * Store a newly created cinema type price in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cinema_chain_id' => 'required|exists:cinema_chains,id',
            'type_id' => 'required|exists:types,id',
            'surcharge' => 'required|numeric|min:0',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
        ]);

        $price = CinemaTypePrice::create($validated);

        return response()->json(['data' => $price], Response::HTTP_CREATED);
    }

    /**
     * Display the specified cinema type price.
     */
    public function show(CinemaTypePrice $cinemaTypePrice)
    {
        return response()->json(['data' => $cinemaTypePrice], Response::HTTP_OK);
    }

    /**
     * Update the specified cinema type price in storage.
     */
    public function update(Request $request, CinemaTypePrice $cinemaTypePrice)
    {
        $validated = $request->validate([
            'cinema_chain_id' => 'sometimes|required|exists:cinema_chains,id',
            'type_id' => 'sometimes|required|exists:types,id',
            'surcharge' => 'sometimes|required|numeric|min:0',
            'effective_from' => 'sometimes|required|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
        ]);

        $cinemaTypePrice->update($validated);

        return response()->json(['data' => $cinemaTypePrice], Response::HTTP_OK);
    }

    /**
     * Remove the specified cinema type price from storage.
     */
    public function destroy(CinemaTypePrice $cinemaTypePrice)
    {
        $cinemaTypePrice->delete();

        return response()->json(['message' => 'Price deleted successfully.'], Response::HTTP_OK);
    }

    /**
     * Get prices for a specific cinema chain and type.
     */
    public function getByChainAndType($cinemaChainId, $typeId)
    {
        $prices = CinemaTypePrice::where(
            'cinema_chain_id',
            $cinemaChainId
        )
            ->where('type_id', $typeId)
            ->get();

        return response()->json(['data' => $prices], Response::HTTP_OK);
    }
}
