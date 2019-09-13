<?php

namespace App\Http\Controllers;

use App\Mail\SendReport;
use App\Recipient;
use App\Traits\C69SharedTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
            'period' => ['required'],
            'message' => ['required'],
            'recipients' => ['required'],
        ]);

        if ($validator->fails()) {
            $errs = array();
            foreach (array_values($validator->getMessageBag()->getMessages()) as $err) {
                $errs = array_merge_recursive($err);
            }
            return response()->json($errs, 500);
        }
        $user = auth()->user();

        //Recepients
       /* $report_recepients = Recipient::where('user_id',intval($user->id))
            ->pluck('recipient')->toArray();
        if(count($report_recepients) <= 0){
            return response()->json(['statusCode'=>1,'statusMessage'=>'You have not set any report recipients','payload'=>[]], 500);
        }
        array_push($report_recepients,$user->email);*/

        $recipient_array = explode(',',$request->get('recipients'));
        $err_msg = null;
        foreach ($recipient_array as $recp){
            if(!filter_var($recp, FILTER_VALIDATE_EMAIL)){
                $err_msg = "The email address ".$recp." is invalid";
            break;
            }
        }

        if($err_msg){
            return response()->json(['statusCode'=>1,'statusMessage'=>$err_msg,'payload'=>[$err_msg]], 500);
        }
        Log::info($err_msg);
        $message = trim($request->get('message'));
        $period = $request->get('period');
        $title = "C69 - ${period} Report";
        $report_data =  $this->get_report($period);
        $data = array('user'=>$user,"title"=>$title,"report_data"=>$report_data);
        $pdf = PDF::loadView('report.template', array('data' => $data));
        $filepath = public_path('reports');
        $filename = Carbon::now()->format('Ymdhis').".pdf";
        $full_path = $filepath.'/'.$filename;
        $pdf->save($full_path);

        //Send email, attach full path
        Mail::cc($recipient_array)
            ->queue(new SendReport($title,$user->name,$message,$full_path));

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
