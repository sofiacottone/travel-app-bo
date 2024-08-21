<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use App\Models\Place;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/places/{place}/photos
     *
     * @param  int  $placeId
     * @return \Illuminate\Http\Response
     */
    public function index($placeId)
    {
        // get all photo from a specific place
        $place = Place::findOrFail($placeId);
        $photos = $place->photos;

        // return a json response
        return response()->json([
            'success' => true,
            'results' => $photos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/places/{place}/photos
     *
     * @param  int  $placeId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $placeId)
    {
        $place = Place::findOrFail($placeId);

        // validate form data
        $formData = $request->validate([
            'url' => 'required|url|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        // add a new photo to a specific place
        $photo = new Photo($formData);
        $photo->place_id = $place->id;
        $photo->save();

        return response()->json([
            'success' => true,
            'results' => $photo
        ]);
    }

    /**
     * Display the specified resource.
     * GET /api/places/{place}/photos/{photo}
     *
     * @param  int  $placeId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($placeId, $id)
    {
        // get the specified photo from a specific place
        $place = Place::findOrFail($placeId);
        $photo = $place->photos()->findOrFail($id);

        return response()->json([
            'success' => true,
            'results' => $photo
        ]);
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/places/{place}/photos/{photo}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $placeId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $placeId, $id)
    {
        $place = Place::findOrFail($placeId);
        $photo = $place->photos()->findOrFail($id);

        // validate form data
        $formData = $request->validate([
            'url' => 'required|url|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        // update the specified photo
        $photo->update($formData);

        return response()->json([
            'success' => true,
            'results' => $photo
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/places/{place}/photos/{photo}
     *
     * @param  int  $placeId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($placeId, $id)
    {
        $place = Place::findOrFail($placeId);
        $photo = $place->photos()->findOrFail($id);

        // delete the specified photo
        $photo->delete();

        // return no content
        return response()->json(null, 204);
    }
}
