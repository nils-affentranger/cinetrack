<?php

namespace App\Http\Controllers;

use App\Models\CinemaPriceHistory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CinemaPriceHistoryController extends Controller
{
    /**
     * Display a listing of the cinema price history records.
     */
    public function index()
    {
        $priceHistory = CinemaPriceHistory::all();

        return response()->json(['data' => $priceHistory], Response::HTTP_OK);
    }

    /**
     * Store a newly created cinema price history record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cinema_id' => 'required|exists:cinemas,id',
            'base_price' => 'required|numeric|min:0',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
        ]);

        $priceHistory = CinemaPriceHistory::create($validated);

        return response()->json(['data' => $priceHistory], Response::HTTP_CREATED);
    }

    /**
     * Display the specified cinema price history record.
     */
    public function show(CinemaPriceHistory $cinemaPriceHistory)
    {
        return response()->json(['data' => $cinemaPriceHistory], Response::HTTP_OK);
    }

    /**
     * Update the specified cinema price history record in storage.
     */
    public function update(Request $request, CinemaPriceHistory $cinemaPriceHistory)
    {
        $validated = $request->validate([
            'cinema_id' => 'sometimes|required|exists:cinemas,id',
            'base_price' => 'sometimes|required|numeric|min:0',
            'effective_from' => 'sometimes|required|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
        ]);

        $cinemaPriceHistory->update($validated);

        return response()->json(['data' => $cinemaPriceHistory], Response::HTTP_OK);
    }

    /**
     * Remove the specified cinema price history record from storage.
     */
    public function destroy(CinemaPriceHistory $cinemaPriceHistory)
    {
        $cinemaPriceHistory->delete();

        return response()->json(['message' => 'Price History deleted successfully.'], Response::HTTP_OK);
    }

    /**
     * Get price history for a specific cinema.
     */
    public function getByCinema($cinemaId)
    {
        $priceHistory = CinemaPriceHistory::where('cinema_id', $cinemaId)->get();

        return response()->json(['data' => $priceHistory], Response::HTTP_OK);
    }
}
