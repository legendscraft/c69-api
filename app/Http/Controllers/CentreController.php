<?php

namespace App\Http\Controllers;

use App\Centre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class CentreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $centres = Centre::where('user_id',intval($user->id))->orderBy('name')->get();
        return response()->json(['statusCode'=>0,'statusMessage'=>count($centres).' Centres found','payload'=>$centres], 200);
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
            'name' => ['required']
        ]);

        if ($validator->fails()) {
            $errs =array();
            foreach (array_values($validator->getMessageBag()->getMessages()) as $err){
                $errs = array_merge_recursive($err);
            }
            return response()->json($errs, 500);
        }
        $name = trim($request->get('name'));
       try{
           $user = auth()->user();
           Centre::create([
               'name'=>$name,
               'user_id'=>intval($user->id)]);
           return response()->json(['statusCode'=>0,'statusMessage'=>'Centre Added Successfully'], 200);
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
        $validator = Validator::make($request->all(), [
            'name' => ['required']
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
            $centre = Centre::where('user_id',intval($user->id))->where('id',$id)->first();
            $centre->name = $name;
            $centre->save();
            return response()->json(['statusCode'=>0,'statusMessage'=>'Centre Updated Successfully'], 200);
        }catch (\Throwable $e){
            Log::error($e->getMessage());
            return response()->json(['statusCode'=>1,'statusMessage'=>'Centre Could not be Updated'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       try{
           $user = auth()->user();
           $centre = Centre::where('user_id',intval($user->id))->where('id',$id)->first();
           $centre->delete();
           return response()->json(['statusCode'=>0,'statusMessage'=>'Centre Deleted Successfully'], 200);
       }catch (\Throwable $e){
           Log::error($e->getMessage());
           return response()->json(['statusCode'=>1,'statusMessage'=>'Centre Could not be deleted'], 500);
       }
    }
}
