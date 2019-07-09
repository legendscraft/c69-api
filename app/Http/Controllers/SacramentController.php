<?php

namespace App\Http\Controllers;

use App\Http\Resources\SacramentResource;
use App\Sacrament;
use App\SacramentRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SacramentController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $data = $request->all();
        foreach ($data as $sacrament_record){
            $id = intval($sacrament_record['id']);
            $sacrament_id = intval($sacrament_record['sacrament_id']);
            $dcount = intval($sacrament_record['dcount']);
            $user_id = intval($user->id);
            $record_date = trim($sacrament_record['record_date']);

            SacramentRecord::where('id',$id)
                ->where('user_id',$user_id)
                ->where('sacrament_id',$sacrament_id)
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
        $sacrament_start_date = Carbon::parse($aDate)->startOfDay();
        $sacrament_end_date = Carbon::parse($aDate)->endOfDay();
        $sacraments_records = SacramentRecord::where('user_id',intval($user->id))
            ->whereRaw(" DATE(record_date) BETWEEN DATE('".$sacrament_start_date."') AND DATE('".$sacrament_end_date."')")
            ->get();
        if(count($sacraments_records) > 0){
            return response()->json(['statusCode'=>0,
                'statusMessage'=>'Records found',
                'payload'=>SacramentResource::collection($sacraments_records)], 200);
        }else{
            //Create Records with count 0 for the day
            $sacraments = Sacrament::all();
            foreach ($sacraments as $sacrament){
                SacramentRecord::create(['sacrament_id'=>intval($sacrament->id),
                    'user_id'=>intval($user->id),
                    'record_date'=>Carbon::parse($aDate)->toDate()]);
            }
            $sacraments_records = SacramentRecord::where('user_id',intval($user->id))
                ->whereRaw(" DATE(record_date) BETWEEN DATE('".$sacrament_start_date."') AND DATE('".$sacrament_end_date."')")
                ->get();
            return response()->json(['statusCode'=>0,'statusMessage'=>'Records found','payload'=>SacramentResource::collection($sacraments_records)], 200);
        }


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
        $sacrament_id = intval($request->get('sacrament_id'));
        $record_date = $request->get('record_date');
        $dcount = intval($request->get('dcount'));
        $sacrament_start_date = Carbon::parse($record_date)->startOfDay();
        $sacrament_end_date = Carbon::parse($record_date)->endOfDay();
        SacramentRecord::where('id',$id)
            ->where('sacrament_id',$sacrament_id)
            ->where('user_id',$user_id)
            ->whereRaw(" DATE(record_date) BETWEEN DATE('".$sacrament_start_date."') AND DATE('".$sacrament_end_date."')")
            ->update(["dcount"=>$dcount]);
        $sacrament_record = SacramentRecord::find($id);
        return response()->json([
            'statusCode'=>0,
            'statusMessage'=>'Record Saved Successfully',
            'payload'=>new SacramentResource($sacrament_record)], 200);
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
