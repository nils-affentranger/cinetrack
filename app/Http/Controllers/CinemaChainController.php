<?php

namespace App\Http\Controllers;

use App\Models\CinemaChain;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CinemaChainController extends Controller
{
    /**
     * Display a listing of the cinema chains, optionally filtered by search term.
     */
    public function index(Request $request)
    {
        $query = CinemaChain::query();

        $searchTerm = $request->input('search');

        if ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        $cinemaChains = $query->get();

        return response()->json(['data' => $cinemaChains], Response::HTTP_OK);
    }

    /**
     * Store a newly created cinema chain in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $cinemaChain = CinemaChain::create($validated);

        return response()->json(['data' => $cinemaChain], Response::HTTP_CREATED);
    }

    /**
     * Display the specified cinema chain.
     */
    public function show(CinemaChain $cinemaChain)
    {
        return response()->json(['data' => $cinemaChain], Response::HTTP_OK);
    }

    /**
     * Update the specified cinema chain in storage.
     */
    public function update(Request $request, CinemaChain $cinemaChain)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $cinemaChain->update($validated);

        return response()->json(['data' => $cinemaChain], Response::HTTP_OK);
    }

    /**
     * Remove the specified cinema chain from storage.
     */
    public function destroy(CinemaChain $cinemaChain)
    {
        if ($cinemaChain->cinemas()->exists()) {
            return response()->json([
                'message' => 'This cinema chain has associated cinemas and cannot be deleted. Please remove the cinemas first.',
            ], Response::HTTP_CONFLICT);
        }

        $cinemaChain->delete();

        return response()->json(['message' => 'Cinema chain deleted successfully.'], Response::HTTP_OK);
    }
}
