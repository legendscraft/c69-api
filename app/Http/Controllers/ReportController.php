<?php

namespace App\Http\Controllers;

use App\PreachingRecord;
use App\SacramentRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = auth()->user();
        $prechings =  PreachingRecord::where('user_id',intval($user->id))
            ->select(DB::raw('sum(dcount) as data'),DB::raw("DATE_FORMAT(record_date, '%M %Y') period"),DB::raw("DATE_FORMAT(record_date, '%m %Y') dperiod"))
            ->orderBy('dperiod','DESC')
            ->groupBy('dperiod','period')
            ->pluck("period")->toArray();
        $sacrements = SacramentRecord::where('user_id',intval($user->id))
            ->select(DB::raw('sum(dcount) as data'),DB::raw("DATE_FORMAT(record_date, '%M %Y') period"),DB::raw("DATE_FORMAT(record_date, '%m %Y') dperiod"))
            ->orderBy('dperiod','DESC')
            ->groupBy('dperiod','period')
            ->pluck("period")->toArray();
        $payload = array_unique(array_merge($prechings,$sacrements));
        return response()->json(['statusCode'=>0,'statusMessage'=>'Reports found','payload'=>$payload], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $period = $request->get('period');
        $start_date = Carbon::parse(1 .' '.$period)->startOfMonth();
        $end_date = Carbon::parse(1 .' '.$period)->endOfMonth();

        $payload = array();


        $user = auth()->user();
        $sacraments =  SacramentRecord::join('sacraments','sacrament_records.sacrament_id','=','sacraments.id')
            ->where('user_id',intval($user->id))
            ->whereBetween('record_date',[$start_date,$end_date])
            ->select('name',DB::raw('sum(dcount) as recs'))
            ->groupBy('name')->get();
        $sacrement_report = array("title"=>"Sacraments",'records'=>$sacraments);
        array_push($payload,$sacrement_report);

        $preachings =  PreachingRecord::join('preachings','preaching_records.preaching_id','=','preachings.id')
            ->where('user_id',intval($user->id))
            ->whereBetween('record_date',[$start_date,$end_date])
            ->select('name',DB::raw('sum(dcount) as recs'))
            ->groupBy('name')->get();
        $preachings_report = array("title"=>"Preaching",'records'=>$preachings);
        array_push($payload,$preachings_report);
        return response()->json(['statusCode'=>0,'statusMessage'=>' Centres found','payload'=>$payload], 200);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

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
