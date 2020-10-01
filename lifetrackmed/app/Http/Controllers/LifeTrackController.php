<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LifeTrack;
use Config;

class LifeTrackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         echo "studiesperram: ".Config::get('constants.studiesperram.studies') . " - " .Config::get('constants.studiesperram.mbram')."<br />";
         echo "gbperhour: ".Config::get('constants.gbperhour.gbram'). " - " .Config::get('constants.gbperhour.hourcost')."<br />";
         echo "mbperstudy: ".Config::get('constants.mbperstudy.study'). " - " .Config::get('constants.mbperstudy.mbram')."<br />";
         echo "storagecost: ".Config::get('constants.storagecost.gbram'). " - " .Config::get('constants.storagecost.monthcost')."<br />";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
     {
            $lifetrack = new LifeTrack();
            $lifetrack->studyday = $request->studyday;
            $lifetrack->studygrowth = $request->studygrowth;
            $lifetrack->forecastmonths = $request->forecastmonths;

            $lifetrack->save();
            return response()->json(['success'=>'Data is successfully added','result'=>$request]);
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
