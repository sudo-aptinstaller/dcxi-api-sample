@extends('layouts.app')

@section('content')
<div class="container">
        {!! Form::open(['action' => ['StatusController@store_status', $name] , 'method' => 'POST']) !!}
            {!! Form::textarea('text_status', $status_text) !!}
            {!! Form::submit('Submit',['class' => 'btn badge-pill bg-dark text-white px-4 py-1']) !!}
        {!! Form::close() !!}
</div>

@endsection