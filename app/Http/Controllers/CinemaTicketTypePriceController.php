<?php

namespace App\Http\Controllers;

use App\Models\CinemaTicketTypePrice;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CinemaTicketTypePriceController extends Controller
{
    /**
     * Display a listing of the cinema ticket type prices.
     */
    public function index()
    {
        $prices = CinemaTicketTypePrice::all();

        return response()->json(['data' => $prices], Response::HTTP_OK);
    }

    /**
     * Store a newly created cinema ticket type price in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cinema_chain_id' => 'required|exists:cinema_chains,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'surcharge' => 'required|numeric|min:0',
            'effective_from' => 'required|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
        ]);

        $price = CinemaTicketTypePrice::create($validated);

        return response()->json(['data' => $price], Response::HTTP_CREATED);
    }

    /**
     * Display the specified cinema ticket type price.
     */
    public function show(CinemaTicketTypePrice $cinemaTicketTypePrice)
    {
        return response()->json(['data' => $cinemaTicketTypePrice], Response::HTTP_OK);
    }

    /**
     * Update the specified cinema ticket type price in storage.
     */
    public function update(Request $request, CinemaTicketTypePrice $cinemaTicketTypePrice)
    {
        $validated = $request->validate([
            'cinema_chain_id' => 'sometimes|required|exists:cinema_chains,id',
            'ticket_type_id' => 'sometimes|required|exists:ticket_types,id',
            'surcharge' => 'sometimes|required|numeric|min:0',
            'effective_from' => 'sometimes|required|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
        ]);

        $cinemaTicketTypePrice->update($validated);

        return response()->json(['data' => $cinemaTicketTypePrice], Response::HTTP_OK);
    }

    /**
     * Remove the specified cinema ticket type price from storage.
     */
    public function destroy(CinemaTicketTypePrice $cinemaTicketTypePrice)
    {
        $cinemaTicketTypePrice->delete();

        return response()->json(['message' => 'Price deleted successfully.'], Response::HTTP_OK);
    }

    /**
     * Get prices for a specific cinema chain and ticket type.
     */
    public function getByChainAndType($cinemaChainId, $ticketTypeId)
    {
        $prices = CinemaTicketTypePrice::where(
            'cinema_chain_id',
            $cinemaChainId
        )
            ->where('ticket_type_id', $ticketTypeId)
            ->get();

        return response()->json(['data' => $prices], Response::HTTP_OK);
    }
}
