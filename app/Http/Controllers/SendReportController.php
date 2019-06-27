<?php

namespace App\Http\Controllers;

use App\Traits\C69SharedTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SendReportController extends Controller
{
    use C69SharedTrait;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'period' => ['required']
        ]);

        if ($validator->fails()) {
            $errs = array();
            foreach (array_values($validator->getMessageBag()->getMessages()) as $err) {
                $errs = array_merge_recursive($err);
            }
            return response()->json($errs, 500);
        }
        $user = auth()->user();
        $period = $request->get('period');
        $title = "C69 SYSTEM - ${period} Report";
        $report_data =  $this->get_report($period);
        $data = array('user'=>$user,"title"=>$title,"report_data"=>$report_data);
        $pdf = PDF::loadView('report.template', array('data' => $data));
        $filepath = public_path('reports');
        $filename = Carbon::now()->format('Ymdhis').".pdf";
        $full_path = $filepath.'/'.$filename;
        $pdf->save($full_path);

        //Send email, attach full path



        unlink($full_path);
        return response()->json(['statusCode'=>0,'statusMessage'=>'Report Sent Successfully','payload'=>[]], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
