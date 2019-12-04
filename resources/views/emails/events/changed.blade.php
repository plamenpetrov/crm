@extends('emails.layout.main')

@section('content')

@component('mail::message')

Hello, {!! $data['userName'] !!}, <br>

Event <strong>{!! $data['name'] !!}</strong> Time has been changed. <br>
Event will start at <strong>{!! $data['startdate'] !!}</strong> and finish at <strong>{!! $data['enddate'] !!}</strong>
<br>
<br>

Event details: <br> 
<br>
@component('mail::panel')
<b>Event descritpion:</b> {!! $data['description'] !!}  <br>
<b>Where:</b> {!! $data['location'] !!} 

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

@stop