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
    public function index(Request $request)
    {
        $validated = $request->validate([
            'cinema_id' => 'sometimes|exists:cinemas,id',
            'cinema_chain_id' => 'sometimes|exists:cinema_chains,id',
            'movie_id' => 'sometimes|exists:movies,id',
            'type_id' => 'sometimes|exists:types,id',
            'date_from' => 'sometimes|date',
            'date_to' => 'sometimes|date',
        ]);

        $visits = Visit::query();

        if (array_key_exists('cinema_id', $validated)) {
            $visits->where('cinema_id', $validated['cinema_id']);
        }

        if (array_key_exists('cinema_chain_id', $validated)) {
            $visits->where('cinema_chain_id', $validated['cinema_chain_id']);
        }

        if (array_key_exists('movie_id', $validated)) {
            $visits->where('movie_id', $validated['movie_id']);
        }

        if (array_key_exists('type_id', $validated)) {
            $visits->where('type_id', $validated['type_id']);
        }

        if (array_key_exists('date_from', $validated)) {
            $visits->where('visit_date', '>=', $validated['date_from']);
        }

        if (array_key_exists('date_to', $validated)) {
            $visits->where('visit_date', '<=', $validated['date_to']);
        }

        $visits = $visits->get();

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
            'type_id' => 'required|exists:types,id',
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
            'type_id' => 'sometimes|required|exists:types,id',
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
