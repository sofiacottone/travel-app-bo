<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Day;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DayController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/trips/{trip}/days
     *
     * @param  int  $tripId
     * @return \Illuminate\Http\Response
     */
    public function index($tripId)
    {
        // get all days for a specific trip
        $trip = Trip::where('user_id', Auth::id())->findOrFail($tripId);
        $days = $trip->days;

        // return a json response
        return response()->json([
            'success' => true,
            'results' => $days
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/trips/{trip}/days
     *
     * @param  int  $tripId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $tripId)
    {
        $trip = Trip::where('user_id', Auth::id())->findOrFail($tripId);

        // validate form data
        $formData = $request->validate([
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // create a new day in a trip
        $day = new Day($formData);
        $day->trip_id = $trip->id;
        $day->save();

        return response()->json([
            'success' => true,
            'results' => $day
        ]);
    }

    /**
     * Display the specified resource.
     * GET /api/trips/{trip}/days/{day}
     *
     * @param  int  $tripId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tripId, $id)
    {
        // get the specified day in a trip
        $trip = Trip::where('user_id', Auth::id())->findOrFail($tripId);
        $day = $trip->days()->findOrFail($id);

        return response()->json([
            'success' => true,
            'results' => $day
        ]);
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/trips/{trip}/days/{day}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $tripId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tripId, $id)
    {
        $trip = Trip::where('user_id', Auth::id())->findOrFail($tripId);
        $day = $trip->days()->findOrFail($id);

        // validate form data
        $formData = $request->validate([
            'date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // update the specified day
        $day->update($formData);

        return response()->json([
            'success' => true,
            'results' => $day
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/trips/{trip}/days/{day}
     *
     * @param  int  $tripId
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($tripId, $id)
    {
        $trip = Trip::where('user_id', Auth::id())->findOrFail($tripId);
        $day = $trip->days()->findOrFail($id);

        $day->delete();

        // return no content
        return response()->json(null, 204);
    }
}
