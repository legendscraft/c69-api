<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\AppointmentComment;
use App\Http\Resources\AppointmentDetailResource;
use App\Http\Resources\AppointmentResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $centreId = intval($request->get('centreId'));
        $user = auth()->user();
        $appointments = Appointment::where('user_id', intval($user->id))->where('centre_id', $centreId)->orderBy('name')->get();
        return response()->json([
            'statusCode' => 0,
            'statusMessage' => count($appointments) . ' Appointments found',
            'payload' => AppointmentResource::collection($appointments)], 200);
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
            'centre' => ['required', 'numeric'],
            'frequency' => ['required', 'numeric'],
            'gender' => ['required', 'numeric'],
            'name' => ['required'],
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
        DB::beginTransaction();
        try {
            $user = auth()->user();
            $name = trim($request->get('name'));
            $gender_id = intval($request->get('gender'));
            $centre_id = intval($request->get('centre'));
            $appointment_frequency_id = intval($request->get('frequency'));
            $user_id = intval($user->id);
            $meeting_date = trim($request->get('mdate'));
            $comment = trim($request->get('comments'));
            $mdate = Carbon::parse($meeting_date)->startOfDay();
            $appointment = Appointment::create([
                'name' => $name,
                'user_id' => $user_id,
                'gender_id' => $gender_id,
                'centre_id' => $centre_id,
                'lastMet' => $mdate,
                'appointment_frequency_id' => $appointment_frequency_id]);

            AppointmentComment::create(['comment' => $comment, 'mdate' => $mdate, 'appointment_id' => intval($appointment->id)]);
            DB::commit();
            return response()->json(['statusCode' => 0, 'statusMessage' => 'Appointment Added Successfully', 'payload' => new AppointmentDetailResource($appointment)], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response()->json(['statusCode' => 1, 'statusMessage' => "'" . $name . "' Already Exists"], 500);
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
        $user = auth()->user();
        $appointment = Appointment::where('id', $id)->where('user_id', intval($user->id))->first();
        if ($appointment == null) {
            return response()->json([
                'statusCode' => 1,
                'statusMessage' => 'Appointment NOT found!',
                'payload' => null], 500);
        }
        return response()->json([
            'statusCode' => 0,
            'statusMessage' => 'Appointment found',
            'payload' => new AppointmentDetailResource($appointment)], 200);
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
