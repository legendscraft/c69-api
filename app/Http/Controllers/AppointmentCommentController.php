<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\AppointmentComment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AppointmentCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
            'appointment_id' => ['required', 'numeric'],
            'comments' => ['required'],
            'mdate' => ['required'],
        ]);

        if ($validator->fails()) {
            $errs = array();
            foreach (array_values($validator->getMessageBag()->getMessages()) as $err) {
                $errs = array_merge_recursive($err);
            }
            return response()->json($errs, 500);
        }

        $user = auth()->user();
        $user_id = intval($user->id);
        $appointment_id = intval($request->get('appointment_id'));
        $appointment = Appointment::where('user_id', $user_id)->where('id', $appointment_id)->first();
        if ($appointment) {
            $comment = trim($request->get('comments'));
            $meeting_date = trim($request->get('mdate'));
            $mdate = Carbon::parse($meeting_date)->startOfDay();
            AppointmentComment::create([
                'comment' => $comment,
                'mdate' => $mdate,
                'appointment_id' => $appointment_id]);
            return response()->json(['statusCode' => 0, 'statusMessage' => "Appointment Comment Saved Successfully"], 200);
        } else {
            return response()->json(['statusCode' => 1, 'statusMessage' => "Appointment not found"], 500);
        }
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = auth()->user();
        AppointmentComment::destroy($id);
        return response()->json(['statusCode'=>0,'statusMessage'=>'Appointment comment deleted successfully','payload'=>[]], 200);
    }
}
