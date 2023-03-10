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
        $user = auth()->user();
        $data = $request->all();
        foreach ($data as $preaching_record){
            $id = intval($preaching_record['id']);
            $preaching_id = intval($preaching_record['preaching_id']);
            $dcount = intval($preaching_record['dcount']);
            $user_id = intval($user->id);
            $record_date = trim($preaching_record['record_date']);

            PreachingRecord::where('id',$id)
                ->where('user_id',$user_id)
                ->where('preaching_id',$preaching_id)
                ->update(['dcount'=>$dcount,'record_date'=>$record_date]);
        }

        return response()->json(['statusCode'=>0,'statusMessage'=>'Records saved Successfully','payload'=>[]], 200);
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
        $user = auth()->user();
        $user_id = intval($user->id);
        $preaching_id = intval($request->get('preaching_id'));
        $record_date = $request->get('record_date');
        $dcount = intval($request->get('dcount'));
        $preaching_start_date = Carbon::parse($record_date)->startOfDay();
        $preaching_end_date = Carbon::parse($record_date)->endOfDay();
        PreachingRecord::where('id',$id)
            ->where('preaching_id',$preaching_id)
            ->where('user_id',$user_id)
            ->whereRaw(" DATE(record_date) BETWEEN DATE('".$preaching_start_date."') AND DATE('".$preaching_end_date."')")
            ->update(["dcount"=>$dcount]);
        $preaching_record = PreachingRecord::find($id);
        return response()->json([
            'statusCode'=>0,
            'statusMessage'=>'Record Saved Successfully',
            'payload'=>new PreachingResource($preaching_record)], 200);
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
