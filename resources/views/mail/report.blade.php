@extends('layouts.mail')
@section('content')
    <p  style="color: #464c50;font-size: 16px;line-height: 25px;margin: 0 0 20px;text-align: left!important;">Hello there,&nbsp;</p>
<<<<<<< HEAD
    <p  style="color: #464c50;font-size: 16px;line-height: 25px;margin: 0 0 20px;text-align: left!important;">{{$xmessage}}.&nbsp;</p>
=======
   <p  style="color: #464c50;font-size: 16px;line-height: 25px;margin: 0 0 20px;text-align: left!important;">{{$xmessage}}.&nbsp;</p>
>>>>>>> f0729ebd63b5f8ef6574a4a6f67e4bc440d51636
    <p  style="color: #464c50;font-size: 16px;line-height: 25px;margin: 0 0 20px;text-align: left!important;">
        <i>Best Regards,<br>{{env('APP_NAME','C69 System')}}</i>
    </p>
@endsection
