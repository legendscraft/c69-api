<?php

namespace App\Http\Controllers;

use App\Traits\C69SharedTrait;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    use C69SharedTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

       /* $user = User::first();
        Auth::login($user);
        $period = 'June 2019';
        $report_data =  $this->get_report($period);
        $data = array('user'=>$user,"title"=>"C69 SYSTEM - ${period} Report","report_data"=>$report_data);
        $pdf = PDF::loadView('report.template', array('data' => $data));
        $filepath = public_path('reports');
        $filename = Carbon::now()->format('Ymdhis').".pdf";
        return $full_path = $filepath.'/'.$filename;
        return $pdf->download('invoice.pdf');
        return $pdf->stream();
        return $pdf->save($full_path);
        return view('report.template',compact('data'));*/
        return view('home');
    }
}
