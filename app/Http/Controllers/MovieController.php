<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class MovieController extends Controller
{
    /**
     * Display a listing of the movies.
     */
    public function index()
    {
        $movies = Movie::all();

        return response()->json(['data' => $movies], Response::HTTP_OK);
    }

    /**
     * Store a newly created movie in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'tmdb_id' => 'nullable|string|max:255|unique:movies,tmdb_id',
            'poster_path' => 'nullable|string|max:255',
            'runtime' => 'nullable|integer',
        ]);

        $movie = Movie::create($validated);

        return response()->json(['data' => $movie], Response::HTTP_CREATED);
    }

    /**
     * Display the specified movie.
     */
    public function show(Movie $movie)
    {
        return response()->json(['data' => $movie], Response::HTTP_OK);
    }

    /**
     * Update the specified movie in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'tmdb_id' => 'nullable|string|max:255|unique:movies,tmdb_id,' . $movie->id,
            'poster_path' => 'nullable|string|max:255',
            'runtime' => 'nullable|integer',
        ]);

        $movie->update($validated);

        return response()->json(['data' => $movie], Response::HTTP_OK);
    }

    /**
     * Remove the specified movie from storage.
     */
    public function destroy(Movie $movie)
    {
        // Check if the movie is in use by any visits
        if ($movie->visits()->exists()) {
            return response()->json([
                'message' => 'This movie has associated visits and cannot be deleted. Remove dependencies first.',
            ], Response::HTTP_CONFLICT);
        }

        // Delete the poster image if it exists
        if ($movie->poster_path) {
            Storage::disk('public')->delete($movie->poster_path);
        }

        $movie->delete();

        return response()->json(['message' => 'Movie deleted successfully.'], Response::HTTP_OK);
    }

    /**
     * Store a poster image and update the movie record.
     */
    public function uploadPoster(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Delete the old poster if it exists
        if ($movie->poster_path) {
            Storage::disk('public')->delete($movie->poster_path);
        }

        $image = $request->file('poster');
        $name = Str::slug($movie->title) . '_' . time();
        $fileName = $name . '.' . $image->getClientOriginalExtension();
        $folder = '/movies/posters';

        $filePath = $image->storeAs($folder, $fileName, 'public');

        $movie->poster_path = $filePath;
        $movie->save();

        return response()->json([
            'data' => $movie,
            'message' => 'Poster uploaded successfully.',
        ], Response::HTTP_OK);
    }

    /**
     * Provides a list of movies for autocomplete.
     */
    public function autocomplete(Request $request)
    {
        $validated = $request->validate([
            'term' => 'required|string',
        ]);

        $searchTerm = $validated['term'];

        $movies = Movie::where('title', 'like', '%' . $searchTerm . '%')
            ->get();

        $results = $movies->map(function ($movie) {
            return [
                'id' => $movie->id,
                'name' => $movie->title, //  Use 'name' for display
                'poster_path' => $movie->poster_path,
            ];
        });

        return response()->json($results, Response::HTTP_OK);
    }

    /**
     * Provides a list of movies for the general search.
     */
    public function search(Request $request)
    {
        $validated = $request->validate([
            'term' => 'nullable|string',
        ]);

        $searchTerm = $validated['term'] ?? '';

        $query = Movie::query();

        if ($searchTerm) {
            $query->where('title', 'like', '%' . $searchTerm . '%');
        }

        $movies = $query->paginate(20); // Add pagination

        return response()->json($movies, Response::HTTP_OK);
    }

}
