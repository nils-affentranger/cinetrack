<?php

namespace App\Http\Controllers;

use App\Models\Auditorium;
use App\Models\Cinema;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuditoriumController extends Controller
{
    /**
     * Display a listing of the auditoriums for a specific cinema.
     */
    public function index(Cinema $cinema)
    {
        $auditoriums = Auditorium::where('cinema_id', $cinema->id)->get();

        return response()->json(['data' => $auditoriums], Response::HTTP_OK);
    }

    /**
     * Store a newly created auditorium for a specific cinema.
     */
    public function store(Request $request, Cinema $cinema)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $auditorium = new Auditorium($validated);
        $auditorium->cinema_id = $cinema->id;
        $auditorium->save();

        return response()->json(['data' => $auditorium], Response::HTTP_CREATED);
    }

    /**
     * Display the specified auditorium.
     */
    public function show(Cinema $cinema, Auditorium $auditorium)
    {
        if ($auditorium->cinema_id != $cinema->id) {
            return response()->json(['message' => 'Auditorium not found in this cinema'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['data' => $auditorium], Response::HTTP_OK);
    }

    /**
     * Update the specified auditorium in storage.
     */
    public function update(Request $request, Cinema $cinema, Auditorium $auditorium)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $auditorium->update($validated);

        return response()->json(['data' => $auditorium], Response::HTTP_OK);
    }

    /**
     * Remove the specified auditorium from storage.
     */
    public function destroy(Cinema $cinema, Auditorium $auditorium)
    {
        if ($auditorium->cinema_id != $cinema->id) {
            return response()->json(['message' => 'Auditorium not found in this cinema'], Response::HTTP_NOT_FOUND);
        }

        // Check if the auditorium is in use by any visits
        if ($auditorium->visits()->exists()) {
            return response()->json([
                'message' => 'This auditorium has associated visits and cannot be deleted. Remove dependencies first.',
            ], Response::HTTP_CONFLICT);
        }

        $auditorium->delete();

        return response()->json(['message' => 'Auditorium deleted successfully.'], Response::HTTP_OK);
    }

    /**
     * Provides a list of auditoriums for autocomplete, filtered by cinema id.
     */
    public function autocomplete(Request $request, Cinema $cinema)
    {
        $validated = $request->validate([
            'term' => 'required|string',
        ]);

        $searchTerm = $validated['term'];

        $auditoriums = Auditorium::where('cinema_id', $cinema->id)
            ->where('name', 'like', '%' . $searchTerm . '%')
            ->get();

        $results = $auditoriums->map(function ($auditorium) {
            return [
                'id' => $auditorium->id,
                'name' => $auditorium->name, //  Use 'name' for display
                'description' => $auditorium->description,
            ];
        });

        return response()->json($results, Response::HTTP_OK);
    }
}
