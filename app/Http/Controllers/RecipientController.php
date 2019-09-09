<?php

namespace App\Http\Controllers;

use App\Recipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RecipientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $payload = Recipient::where('user_id',intval($user->id))->select('id','recipient')->get();
        return response()->json(['statusCode'=>0,'statusMessage'=>count($payload).' Recipient found','payload'=>$payload], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $recipient = trim($request->get('recipient'));
        $validator = Validator::make($request->all(), [
            'recipient' => ['required','email','unique:recipients,recipient,NULL,id,user_id,'.$user->id]
        ]);

        if ($validator->fails()) {
            $errs =array();
            foreach (array_values($validator->getMessageBag()->getMessages()) as $err){
                $errs = array_merge_recursive($err);
            }

            return response()->json(['statusCode'=>1,'statusMessage'=>$errs[0],'payload'=>$err], 500);
        }

        Recipient::create([
            'recipient'=>$recipient,
            'user_id'=>intval($user->id),
        ]);

        return response()->json(['statusCode'=>0,'statusMessage'=>'Recipient added successfully','payload'=>[]], 200);
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
