<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Resources\AppointmentResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $appointments = Appointment::where('user_id',intval($user->id))->orderBy('name')->get();
        return response()->json([
            'statusCode'=>0,
            'statusMessage'=>count($appointments).' Appointments found',
            'payload'=>AppointmentResource::collection($appointments)], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'centre' => ['required','numeric'],
            'frequency' => ['required','numeric'],
            'gender' => ['required','numeric'],
            'name' => ['required'],
        ]);

        if ($validator->fails()) {
            $errs =array();
            foreach (array_values($validator->getMessageBag()->getMessages()) as $err){
                $errs = array_merge_recursive($err);
            }
            return response()->json($errs, 500);
        }
        try{
        $user = auth()->user();
        $name = trim($request->get('name'));
        $gender_id = intval($request->get('gender'));
        $centre_id = intval($request->get('centre'));
        $appointment_frequency_id = intval($request->get('frequency'));
        $user_id = intval($user->id);
        $appointment = Appointment::create([
            'name'=>$name,
            'user_id'=>$user_id,
            'gender_id'=>$gender_id,
            'centre_id'=>$centre_id,
            'appointment_frequency_id'=>$appointment_frequency_id]);

            return response()->json(['statusCode'=>0,'statusMessage'=>'Appointment Added Successfully','payload'=>new AppointmentResource($appointment)], 200);
        }catch (\Throwable $e){
            Log::error($e->getMessage());
            return response()->json(['statusCode'=>1,'statusMessage'=>"'".$name."' Already Exists"], 500);
        }

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
        //
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
