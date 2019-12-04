@extends('emails.layout.main')

@section('content')

@component('mail::message')

New event has been created and assigned to you. <br><br>
Event details: <br> 
<br>

@component('mail::panel')
<b>Event name:</b>  {!! $data['name'] !!} <br>
<b>Event descritpion:</b> {!! $data['description'] !!}  <br>
<b>Where:</b> {!! $data['location'] !!} 

Event start at <strong>{!! $data['startdate'] !!}</strong> and finish at <strong>{!! $data['enddate'] !!}</strong>
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

@stop