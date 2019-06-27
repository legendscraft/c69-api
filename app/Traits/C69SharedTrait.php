<?php

namespace App\Traits;

use App\PreachingRecord;
use App\SacramentRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait C69SharedTrait
{

    public  function  get_report($period){
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
        return $payload;

    }

}
