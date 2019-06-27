@extends('layouts.mail')
@section('content')
    <p  style="color: #464c50;font-size: 16px;line-height: 25px;margin: 0 0 20px;text-align: left!important;">Dear {{ $attachment->user->name }},&nbsp;</p>

    <p  style="color: #464c50;font-size: 16px;line-height: 25px;margin: 0 0 20px;text-align: left!important;">Your <strong>{{ $attachment->attachmentType->name }}</strong> at <strong>{{ $attachment->hostSupervisor->organization->organization_name }}</strong> has been <strong>{{ $attachment->status }}</strong> by the Attachment Coordinator for the following reason:</p>
    <p  style="color: #464c50;font-size: 16px;line-height: 25px;margin: 0 0 20px;text-align: left!important;"><strong>{{ $attachment->status_message }}</strong></p>

    <p  style="color: #464c50;font-size: 16px;line-height: 25px;margin: 0 0 20px;text-align: left!important;">
        For more information and guidance, contact the Attachment Coordination Office.
    </p>
    <p  style="color: #464c50;font-size: 16px;line-height: 25px;margin: 0 0 20px;text-align: left!important;">
        Click on the button below to access your attachment portal account
    </p>

    <div style="line-height: 1.5; margin: 30px auto; width: 100%;padding: 10px;"><a href="{{ env('APP_URL')}}" style="background-color: #3a5dae;border-radius: 3px;color: #fff;display: block;font-size: 14px;font-weight: bold;height: 42px;line-height: 42px;min-height: 20px;text-align: center;text-decoration: none;text-transform: uppercase;" target="_blank">Go to Account</a>
    </div>

    <p  style="color: #464c50;font-size: 16px;line-height: 25px;margin: 0 0 20px;text-align: left!important;"><i>Best Regards,<br>Strathmore University Attachment System</i></p>

@endsection