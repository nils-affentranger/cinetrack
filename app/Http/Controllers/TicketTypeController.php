<?php

namespace App\Http\Controllers;

use App\Models\TicketType;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TicketTypeController extends Controller
{
    /**
     * Display a listing of the ticket types.
     */
    public function index()
    {
        $ticketTypes = TicketType::all();

        return response()->json(['data' => $ticketTypes], Response::HTTP_OK);
    }

    /**
     * Store a newly created ticket type in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $ticketType = TicketType::create($validated);

        return response()->json(['data' => $ticketType], Response::HTTP_CREATED);
    }

    /**
     * Display the specified ticket type.
     */
    public function show(TicketType $ticketType)
    {
        return response()->json(['data' => $ticketType], Response::HTTP_OK);
    }

    /**
     * Update the specified ticket type in storage.
     */
    public function update(Request $request, TicketType $ticketType)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $ticketType->update($validated);

        return response()->json(['data' => $ticketType], Response::HTTP_OK);
    }

    /**
     * Remove the specified ticket type from storage.
     */
    public function destroy(TicketType $ticketType)
    {
        // Check if the ticket type is in use by any visits
        if ($ticketType->visits()->exists()) {
            return response()->json([
                'message' => 'This ticket type has associated visits and cannot be deleted. Remove dependencies first.',
            ], Response::HTTP_CONFLICT);
        }

        // Check if the ticket type is in use by any cinema ticket type prices
        if ($ticketType->cinemaTicketTypePrices()->exists()) {
            return response()->json([
                'message' => 'This ticket type is in use by cinema ticket type prices and cannot be deleted. Remove dependencies first.',
            ], Response::HTTP_CONFLICT);
        }

        $ticketType->delete();

        return response()->json(['message' => 'Ticket Type deleted successfully.'], Response::HTTP_OK);
    }
}
