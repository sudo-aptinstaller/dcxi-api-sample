@extends('layouts.app')

@section('content')
<div class="container-fluid row">
        <div class="col-2 border-right">
            <div class="row">
                <button class="btn text-white w-100" onclick="idle_window()">Main</button>
            </div>
            <div class="row">
                <button class="btn text-white w-100">button 1</button>
            </div>
            <div class="row">
                <button class="btn text-white w-100">button 1</button>
            </div>
            <div class="row">
                <button class="btn text-white w-100" onclick="api_window()">API & Tokens</button>
            </div>
            <div class="row">
                <button class="btn text-white w-100" onclick="status_window('{{auth()->user()->name}}')">Change Status</button>
            </div>
        </div>
        <div class="col-lg-10" id="main_window">

            <div class="container" id="idle">
                <h4>Welcome {{auth()->user()->name}}, <br> Hope you are having a great day.</h4>
                <div class="container">
                    <a class="btn btn-light text-dark form-control w-25 d-block my-2" onclick="get_status('{{auth()->user()->name}}')">Get status</a>
                    <p class="d-block" id="status_return"></p>
                    
                    
                </div>
            </div>

            
        </div>
        
        <div class="container" id="status_window">
            {!! Form::open(['action' => ['MainController@status_ajax_store', auth()->user()->name], 'method' => 'POST']) !!}
            {!! Form::text('text_status', '', ['id' => 'status_text', 'class' => 'd-block form-control w-25']) !!}
            {!! Form::submit('Submit', ['class' => 'my-2 px-3 py-1 btn border border-white text-white d-block']) !!}
            {!! Form::close() !!}
        </div>

        <div class="container" id="token_window">
            <p>Active token : <kbd id="token_value">{{$token->token_plain ?? 'No Active Tokens' }}</kbd></p>
            <a class="btn btn-danger text-white form-control w-25 d-block my-2" onclick="revoke_token('{{auth()->user()->name}}')">Revoke Token</a>
            {!! Form::open(['action' => 'MainController@generate_token', 'method' => 'POST']) !!}
            {!! Form::label('password', 'Enter Password To Generate Token') !!}
            {!! Form::password('password',['class' => 'd-block form-control w-25']) !!}
            {!! Form::submit('Submit', ['class' => 'my-2 px-3 py-1 btn border border-white text-white d-block']) !!}
            {!! Form::close() !!}
        </div>
</div>
<script>

$(document).ready(function(){
    $("#status_window").hide();
    $("#token_window").hide();
});

function status_window(name){
    $("#token_window").hide();
    $("#idle").hide();
    $.ajax({
        type: "GET",
        url: "/dash/change-status/"+name,
        data: "",
        dataType: "JSON",
        success: function (response) {
        $("#status_window").children('form').children("#status_text").val(response.text_status);
        $("#main_window").append($("#status_window"));
        $("#status_window").show();
        }
    });
}

function api_window(){
    $("#idle").hide();
    $("#status_window").hide();
    $("#main_window").append($("#token_window"));
    $("#token_window").show();
}

function idle_window(){
    $("#status_window").hide();
    $("#token_window").hide();
    $("#idle").show();
}
</script>



<script>
    function get_status(name){
        var auth_token = $("#token_value").text();
        $.ajax({
            type: "GET",
            url: "../api/"+name+"/get-status",
            dataType: "JSON",
            headers : {'Authorization' : 'Bearer '+auth_token},
            success: function (response) {
                $("#status_return").html('<kbd>'+response.data.name + " : " + response.data.status+'</kbd>');
            },
            error: function (jqXHR, exception){
                $("#status_return").html('<kbd>'+jqXHR.status+' : '+jqXHR.statusText+'</kbd>');
            }
        });
    }



    

    function revoke_token(name){
        $.ajaxSetup({

          headers: {

              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

          }

        });
        $.ajax({
            type: "POST",
            url: '/dash/revoke-token/'+name,
            dataType: "JSON",
            success: function (response) {
                location.href = '/login'
            }
        });
    }
</script>
@endsection