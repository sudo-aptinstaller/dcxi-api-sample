<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use App\Http\Resources\Status as StatusResource;
use App\Http\Resources\AppVersion as VersionResource;
use App\AppVersion;

class PagesController extends Controller
{
    public function index(){
        return view('index');
    }

    public function status_get($name){

        $status = Status::where('name','=',$name)->first();
            return new StatusResource($status);
    }
    
    public function get_covid_status(){
        return view('cov');
    }

    public function getAppVersion($appName){

        $getApp = AppVersion::where('app_name','=',$appName)->first();
        return new VersionResource($getApp);
    }
}
