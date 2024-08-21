<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Day;
use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/days/{day}/places
     *
     * @param  int  $dayId
     * @return \Illuminate\Http\Response
     */
    public function index($dayId)
    {
        // get all places from a specific day
        $day = Day::where('id', $dayId)->findOrFail();
        $places = $day->places;

        // return a json response
        return response()->json([
            'success' => true,
            'results' => $places
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/days/{day}/places
     *
     * @param  int  $dayId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $dayId)
    {
        $day = Day::where('id', $dayId)->findOrFail();

        // validate form data
        $formData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'is_visited' => 'boolean',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        // create a new place for a specific day
        $place = new Place($formData);
        $place->day_id = $day->id;
        $place->save();

        return response()->json([
            'success' => true,
            'results' => $place
        ]);
    }

    /**
     * Display the specified resource.
     * GET /api/days/{day}/places/{place}
     *
     * @param  int  $dayId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($dayId, $id)
    {
        // get the specified place from a specific day
        $day = Day::where('id', $dayId)->findOrFail();
        $place = $day->places()->findOrFail($id);

        return response()->json([
            'success' => true,
            'results' => $place
        ]);
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/days/{day}/places/{place}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $dayId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $dayId, $id)
    {
        $day = Day::where('id', $dayId)->findOrFail();
        $place = $day->places()->findOrFail($id);

        // validate form data
        $formData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'is_visited' => 'boolean',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        // update the specified place
        $place->update($formData);

        return response()->json([
            'success' => true,
            'results' => $place
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/days/{day}/places/{place}
     *
     * @param  int  $dayId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($dayId, $id)
    {
        $day = Day::where('id', $dayId)->findOrFail();
        $place = $day->places()->findOrFail($id);

        $place->delete();

        // return no content
        return response()->json(null, 204);
    }
}
