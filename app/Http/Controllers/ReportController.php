<?php

namespace App\Http\Controllers;

use App\PreachingRecord;
use App\Recipient;
use App\SacramentRecord;
use App\Traits\C69SharedTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    use C69SharedTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user = auth()->user();
        $prechings =  PreachingRecord::where('user_id',intval($user->id))
            ->select(DB::raw('sum(dcount) as data'),DB::raw("DATE_FORMAT(record_date, '%M %Y') period"),
                DB::raw("DATE_FORMAT(record_date, '%m %Y') dperiod"))
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
        $user = auth()->user();
        //Recepients
        $recepients = Recipient::where('user_id',intval($user->id))
            ->pluck('recipient')->toArray();
        if(count($recepients) <= 0){
            return response()->json(['statusCode'=>1,'statusMessage'=>'You have not set any report recipients','payload'=>[]], 500);
        }
        $report = $this->get_report($period);
        return response()->json(['statusCode'=>0,'statusMessage'=>'Report found',
            'payload'=>array('report'=>$report,'recepients'=>$recepients)], 200);
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
