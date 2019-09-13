@extends('layouts.mail')
@section('content')
    <p  style="color: #464c50;font-size: 16px;line-height: 25px;margin: 0 0 20px;text-align: left!important;">Hello there,&nbsp;</p>
    <p  style="color: #464c50;font-size: 16px;line-height: 25px;margin: 0 0 20px;text-align: left!important;">
        {{$message}}.&nbsp;</p>
    <p  style="color: #464c50;font-size: 16px;line-height: 25px;margin: 0 0 20px;text-align: left!important;">
        <i>Best Regards,<br>{{env('APP_NAME','C69 System')}}</i>
    </p>
@endsection
