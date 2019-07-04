<?php

namespace App\Traits;

use App\Preaching;
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
        $preachings = Preaching::get();
        $preachings_data =array();
        foreach ($preachings as $preaching){
            $preaching_record =  PreachingRecord::where('user_id',intval($user->id))
                ->where('preaching_id',intval($preaching->id))
                ->whereBetween('record_date',[$start_date,$end_date])
                ->select('preaching_id',DB::raw('sum(dcount) as recs'))
                ->groupBy('preaching_id')->get();
            array_push($preachings_data,array('name'=>$preaching->name,'recs'=>$preaching_record['recs']));
        }

        $preachings_report = array("title"=>"Preaching",'records'=>$preachings_data);
        array_push($payload,$preachings_report);

        $sacraments =  SacramentRecord::join('sacraments','sacrament_records.sacrament_id','=','sacraments.id')
            ->where('user_id',intval($user->id))
            ->whereBetween('record_date',[$start_date,$end_date])
            ->select('name',DB::raw('sum(dcount) as recs'))
            ->groupBy('name')->get();
        $sacrement_report = array("title"=>"Sacraments",'records'=>$sacraments);
        array_push($payload,$sacrement_report);
        return $payload;

    }

}
