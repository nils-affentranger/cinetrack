<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeController extends Controller
{
    /**
     * Display a listing of the types.
     */
    public function index()
    {
        $types = Type::all();

        return response()->json(['data' => $types], Response::HTTP_OK);
    }

    /**
     * Store a newly created type in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $type = Type::create($validated);

        return response()->json(['data' => $type], Response::HTTP_CREATED);
    }

    /**
     * Display the specified type.
     */
    public function show(Type $type)
    {
        return response()->json(['data' => $type], Response::HTTP_OK);
    }

    /**
     * Update the specified type in storage.
     */
    public function update(Request $request, Type $type)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $type->update($validated);

        return response()->json(['data' => $type], Response::HTTP_OK);
    }

    /**
     * Remove the specified type from storage.
     */
    public function destroy(Type $type)
    {
        // Check if the type is in use by any visits
        if ($type->visits()->exists()) {
            return response()->json([
                'message' => 'This type has associated visits and cannot be deleted. Remove dependencies first.',
            ], Response::HTTP_CONFLICT);
        }

        // Check if the type is in use by any cinema type prices
        if ($type->cinemaTypePrices()->exists()) {
            return response()->json([
                'message' => 'This type is in use by cinema type prices and cannot be deleted. Remove dependencies first.',
            ], Response::HTTP_CONFLICT);
        }

        $type->delete();

        return response()->json(['message' => 'Type deleted successfully.'], Response::HTTP_OK);
    }
}
