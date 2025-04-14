<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitController extends Controller
{
    /**
     * Display a listing of the visits.
     */
    public function index()
    {
        $visits = Visit::all();

        return response()->json(['data' => $visits], Response::HTTP_OK);
    }

    /**
     * Store a newly created visit in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'cinema_id' => 'required|exists:cinemas,id',
            'auditorium_id' => 'required|exists:auditoriums,id',
            'ticket_type_id' => 'required|exists:ticket_types,id',
            'visit_date' => 'required|date',
            'row' => 'required|string|max:255',
            'seat' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $visit = Visit::create($validated);

        return response()->json(['data' => $visit], Response::HTTP_CREATED);
    }

    /**
     * Display the specified visit.
     */
    public function show(Visit $visit)
    {
        return response()->json(['data' => $visit], Response::HTTP_OK);
    }

    /**
     * Update the specified visit in storage.
     */
    public function update(Request $request, Visit $visit)
    {
        $validated = $request->validate([
            'movie_id' => 'sometimes|required|exists:movies,id',
            'cinema_id' => 'sometimes|required|exists:cinemas,id',
            'auditorium_id' => 'sometimes|required|exists:auditoriums,id',
            'ticket_type_id' => 'sometimes|required|exists:ticket_types,id',
            'visit_date' => 'sometimes|required|date',
            'row' => 'sometimes|required|string|max:255',
            'seat' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
        ]);

        $visit->update($validated);

        return response()->json(['data' => $visit], Response::HTTP_OK);
    }

    /**
     * Remove the specified visit from storage.
     */
    public function destroy(Visit $visit)
    {
        $visit->delete();

        return response()->json(['message' => 'Visit deleted successfully.'], Response::HTTP_OK);
    }
}
