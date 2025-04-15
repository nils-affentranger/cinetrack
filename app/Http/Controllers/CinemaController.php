<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CinemaController extends Controller
{
    /**
     * Display a listing of the cinemas, optionally filtered by cinema chain.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'cinema_chain_id' => 'sometimes|exists:cinema_chains,id',
        ]);

        $query = Cinema::query();

        if (array_key_exists('cinema_chain_id', $validated)) {
            $query->where('cinema_chain_id', $validated['cinema_chain_id']);
        }

        $cinemas = $query->get();

        return response()->json(['data' => $cinemas], Response::HTTP_OK);
    }

    /**
     * Store a newly created cinema in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'cinema_chain_id' => 'required|exists:cinema_chains,id',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $cinema = Cinema::create($validated);

        return response()->json(['data' => $cinema], Response::HTTP_CREATED);
    }

    /**
     * Display the specified cinema.
     */
    public function show(Cinema $cinema)
    {
        return response()->json(['data' => $cinema], Response::HTTP_OK);
    }

    /**
     * Update the specified cinema in storage.
     */
    public function update(Request $request, Cinema $cinema)
    {
        $validated = $request->validate([
            'cinema_chain_id' => 'sometimes|exists:cinema_chains,id',
            'name' => 'sometimes|required|string|max:255',
            'location' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $cinema->update($validated);

        return response()->json(['data' => $cinema], Response::HTTP_OK);
    }

    /**
     * Remove the specified cinema from storage.
     */
    public function destroy(Cinema $cinema)
    {
        // Check if the cinema is in use by any visits
        if ($cinema->visits()->exists()) {
            return response()->json([
                'message' => 'This cinema has associated visits and cannot be deleted.  Please remove the visits first.',
            ], Response::HTTP_CONFLICT);
        }

        $cinema->delete();

        return response()->json(['message' => 'Cinema deleted successfully.'], Response::HTTP_OK);
    }

    /**
     * Provides a list of cinemas for autocomplete.
     */
    public function autocomplete(Request $request)
    {
        $validated = $request->validate([
            'term' => 'required|string',
        ]);

        $searchTerm = $validated['term'];

        $cinemas = Cinema::where('name', 'like', '%' . $searchTerm . '%')
            ->get();

        $results = $cinemas->map(function ($cinema) {
            return [
                'id' => $cinema->id,
                'name' => $cinema->name, //  Use 'name' for display
                'location' => $cinema->location,
                // Add other relevant fields as needed
            ];
        });

        return response()->json($results, Response::HTTP_OK);
    }

    /**
     * Provides a list of cinemas for the general search.
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'term' => 'nullable|string',
        ]);

        $searchTerm = $validated['term'] ?? '';

        $query = Cinema::query();

        if ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('location', 'like', '%' . $searchTerm . '%'); // Search name and location
        }

        $cinemas = $query->paginate(10); // Add pagination

        return response()->json($cinemas, Response::HTTP_OK);
    }
}
