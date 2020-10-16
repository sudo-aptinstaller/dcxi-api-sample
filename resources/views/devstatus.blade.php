@extends('layouts.main')

@section('body-goes-here')
    <div class="container">
        <div class="row my-5">
            @foreach($status as $dev_stat)
                <div class="col-lg-4 text-center">
                    <p class="lead">{{$dev_stat->name}} : {{$dev_stat->text_status}}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection