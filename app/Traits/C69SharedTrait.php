<?php

namespace App\Traits;

use App\Preaching;
use App\PreachingRecord;
use App\Sacrament;
use App\SacramentRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait C69SharedTrait
{

    public  function  get_report($aperiod){
        $period = trim($aperiod);
        $start_date = Carbon::parse(1 .' '.$period)->startOfMonth();
        $end_date = Carbon::parse(1 .' '.$period)->endOfMonth();

        $payload = array();
        $user = auth()->user();
        $preachings = Preaching::get();
        $preachings_data =array();
        foreach ($preachings as $preaching){
            $preaching_record =  PreachingRecord::where('user_id',intval($user->id))
                ->where('preaching_id',intval($preaching->id))
                ->whereBetween('record_date',[$start_date,$end_date])
                ->select('preaching_id',DB::raw('sum(dcount) as recs'))
                ->groupBy('preaching_id')->first();
            array_push($preachings_data,array('name'=>$preaching->name,'recs'=>$preaching_record->recs));
        }

        $preachings_report = array("title"=>"Preaching",'records'=>$preachings_data);
        array_push($payload,$preachings_report);

        $sacraments = Sacrament::get();
        $sacraments_data =array();
        foreach ($sacraments as $sacrament){
            $sacrament_record =  SacramentRecord::where('user_id',intval($user->id))
                ->where('sacrament_id',intval($sacrament->id))
                ->whereBetween('record_date',[$start_date,$end_date])
                ->select('sacrament_id',DB::raw('sum(dcount) as recs'))
                ->groupBy('sacrament_id')->first();
            array_push($sacraments_data,array('name'=>$sacrament->name,'recs'=>$sacrament_record->recs));
        }
        $sacrement_report = array("title"=>"Sacraments",'records'=>$sacraments_data);
        array_push($payload,$sacrement_report);
        return $payload;

    }

}
