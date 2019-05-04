<?php

namespace App\Http\Controllers;

use App\Http\Resources\PreachingResource;
use App\Preaching;
use App\PreachingRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PreachingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($aDate)
    {
        $user = auth()->user();
        $preaching_start_date = Carbon::parse($aDate)->startOfDay();
        $preaching_end_date = Carbon::parse($aDate)->endOfDay();
        $preaching_records = PreachingRecord::where('user_id',intval($user->id))
            ->whereRaw(" DATE(record_date) BETWEEN DATE('".$preaching_start_date."') AND DATE('".$preaching_end_date."')")
            ->get();
        if(count($preaching_records) > 0){
           return response()->json(['statusCode'=>0,'statusMessage'=>'Records found','payload'=>PreachingResource::collection($preaching_records)], 200);
        }else{
            //Create Records with count 0 for the day
            Log::info("None, creating data....");
            $preachings = Preaching::all();
            foreach ($preachings as $preaching){
                PreachingRecord::create(['preaching_id'=>intval($preaching->id),'user_id'=>intval($user->id),'record_date'=>Carbon::parse($aDate)->toDate()]);
            }
            $preaching_records = PreachingRecord::where('user_id',intval($user->id))
                ->whereRaw(" DATE(record_date) BETWEEN DATE('".$preaching_start_date."') AND DATE('".$preaching_end_date."')")
                ->get();
            return response()->json(['statusCode'=>0,'statusMessage'=>'Records found','payload'=>PreachingResource::collection($preaching_records)], 200);
        }


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
