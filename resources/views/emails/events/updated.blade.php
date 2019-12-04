@extends('emails.layout.main')

@section('content')

@component('mail::message')

Hello, {!! $data['userName'] !!}, <br>

Event <strong>{!! $data['name'] !!}</strong> has been changed. <br><br>
Event details: <br> 
<br>
@component('mail::panel')
<b>Event descritpion:</b> {!! $data['description'] !!}  <br>
<b>Where:</b> {!! $data['location'] !!} 

Event start at <strong>{!! $data['startdate'] !!}</strong> and finish at <strong>{!! $data['enddate'] !!}</strong>
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

@stop