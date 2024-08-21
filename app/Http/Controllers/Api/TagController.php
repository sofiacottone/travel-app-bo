<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/tags
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all tags
        $tags = Tag::all();

        // return a json response
        return response()->json([
            'success' => true,
            'results' => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/tags
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate form data
        $formData = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name',
            'description' => 'nullable|string',
        ]);

        // create a new tag
        $tag = Tag::create($formData);

        return response()->json([
            'success' => true,
            'results' => $tag
        ]);
    }

    /**
     * Attach the specified tag to a place.
     * POST /api/places/{place}/tags/{tag}
     *
     * @param  int  $tagId
     * @param  int  $placeId
     * @return \Illuminate\Http\Response
     */
    public function attachTagToPlace(Request $request, $tagId, $placeId)
    {
        $tag = Tag::findOrFail($tagId);
        $place = Place::findOrFail($placeId);

        $place->tags()->attach($tagId);

        return response()->json([
            'success' => true,
            'message' => 'Tag successfully attached to place'
        ]);
    }

    /**
     * Detach the specified tag from a place.
     * DELETE /api/places/{place}/tags/{tag}
     * 
     * @param  int  $tagId
     * @param  int  $placeId
     * @return \Illuminate\Http\Response
     */
    public function detachTagToPlace($tagId, $placeId)
    {
        $place = Place::findOrFail($placeId);

        $place->tags()->detach($tagId);

        return response()->json([
            'success' => true,
            'message' => 'Tag successfully detached from place'
        ]);
    }
}
