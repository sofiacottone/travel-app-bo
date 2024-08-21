<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/trips
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all trips for the authenticated user
        $trips = Trip::where('user_id', Auth::id())->get();

        // return a json response
        return response()->json([
            'success' => true,
            'results' => $trips
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/trips
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate form data
        $formData = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // create a new trip for the auth user
        $trip = new Trip($formData);
        $trip->user_id = Auth::id();
        $trip->save();

        return response()->json([
            'success' => true,
            'results' => $trip
        ]);
    }

    /**
     * Display the specified resource.
     * GET /api/trips/{trip}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get the specified trip for the auth user
        $trip = Trip::where('user_id', Auth::id())->findOrFail($id);

        return response()->json([
            'success' => true,
            'results' => $trip
        ]);
    }

    /**
     * Update the specified resource in storage.
     * PUT /api/trips/{trip}
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate form data
        $formData = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // update the specified trip for the auth user
        $trip = Trip::where('user_id', Auth::id())->findOrFail($id);
        $trip->update($formData);

        return response()->json([
            'success' => true,
            'results' => $trip
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/trips/{trip}
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete the specified trip for the auth user
        $trip = Trip::where('user_id', Auth::id())->findOrFail($id);
        $trip->delete();

        // return no content
        return response()->json(null, 204);
    }
}
