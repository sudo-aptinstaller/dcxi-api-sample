@extends('layouts.main')
@section('body-goes-here')

<div class="row container-fluid bg-white">
    <div class=" mt-5 col-12" >
        <h2 class="d-flex justify-content-center" style='font-family:helvetica;'>India COVID19 Statistics</h2>
    </div>
</div>

<div class ="row container-fluid pt-5 bg-white">
    <select name="stateSelector" class='form-control mx-auto w-50' id ="stateSelector">
        <option value="0" disabled="true" selected="true">Select a state</option>
    </select>
</div>

<div class="row container-fluid bg-white">
    <div class=" mt-5 col-12" id="covid">
        <h2 class="d-flex justify-content-center" style='font-family:helvetica;'></h2>
    </div>
</div>

<div class="d-flex justify-content-center pt-5 bg-white">
        <h6 class="d-flex">  <small>Source : covid19india.org | For official data visit www.mohfw.gov.in</small>  </h6>
</div>



<script>
	
	$.getJSON("https://api.covid19india.org/state_district_wise.json",
		function (data, textStatus, jqXHR) {
		    
		    var stateList = new Array;
		    var districtList = new Array;
		    var allDistrictObj, allStateObj;
		    var stateCount = 0;
		    var distCount = 0;
		    
		    for (allStateObj in data){
		        stateList[stateCount] = allStateObj;
		        stateCount++;
		        
		    }
		    
		    
		    for(var i = 1 ; i < stateCount; i++ ){
		        
		        $("#stateSelector").append("<option value= '"+stateList[i]+"'>"+stateList[i]+"</option>");
		    }
		    
		    
		    $("#stateSelector").on('change', function(){
		        
		        $("#covid").empty();
		        
		        
		        distCount = 0 ;
		        
		        districtList = [];
		        
		        var stateSelect = $(this).val();
		        
		        var stateVal = 'data["'+stateSelect+'"].districtData';
		        
		        stateVal = eval(stateVal);
		        
		        
		        for( allDistrictObj in stateVal){
		            
    		        districtList[distCount] = allDistrictObj;
    		        
    		        distCount++;
    		        
    		        
    		        
		            }
		            
		            distCount = districtList.length;
    		        
		          for(var i = 0 ; i < distCount ; i ++){
		              
        		        var districtName = districtList[i];
        		        
        		        var name = 'data["'+stateSelect+'"].districtData["'+districtName+'"]';
        		        
        		        var name = eval(name);

        		        
        		      //data_collector code
        		            
        		        var file = eval(name);
                        var name = 'data["'+stateSelect+'"].districtData["'+districtName+'"].delta';
            	        var daily = eval(name);
            	        console.log(daily);
            	        var daily_ratio = (daily.recovered/daily.confirmed) * 100;
            	        daily_ratio = daily_ratio.toString();
            	        var daily_data = daily_ratio.substring(0,5);
            	        var recovery_ratio = (file.recovered/file.confirmed) * 100;
            	        recovery_ratio = recovery_ratio.toString();
            	        var recovery = recovery_ratio.substring(0,5);  
            	        
            	        
            	        // element selector code
            	      
            	        $("#covid").append("<h3 class='d-flex justify-content-lg-center text-uppercase pb-3 pt-2' style='font-family:helvetica; '>"+districtName+"</h3><div class='d-flex px-2'><div class='col-lg-12'><div id='covid_text_total_"+i+"' class='lead'></div></div></div><hr>")
            	      
						$("#covid_text_total_"+i).append(" <div class='d-lg-flex d-flex-fill justify-content-lg-center justify-content-left mb-2'> <h5 class='d-inline px-lg-3'  style='font-family:helvetica; font-weight:bold; '>  <mark class='d-inline-flex pb-2' style='background-color:white; border-radius:5px;'> <p class='d-inline-flex' style='font-size:16px; font-weight:lighter' >Active ► </p> "+file.active+"</mark></h5> <h5 class='d-inline px-3'  style='font-family:helvetica; font-weight:bold; '>  <mark class='d-inline-flex pb-2' style='background-color:white; border-radius:5px;'> <p class='d-inline-flex' style='font-size:16px; font-weight:lighter' > Confirmed ► </p> "+file.confirmed+"</mark> <mark class='d-inline-flex' style='background-color:red; color:white; border-radius:5px;'>▲"+daily.confirmed+" </mark> </h5> <h5 class='d-inline px-3'  style='font-family:helvetica; font-weight:bold; '>  <mark class='d-inline-flex pb-2' style='background-color:white; border-radius:5px;'> <p class='d-inline-flex' style='font-size:16px; font-weight:lighter' > Recovered ► </p> "+file.recovered+"</mark> <mark class='d-inline-flex' style='background-color:green; color:white; border-radius:5px;'>▲"+daily.recovered+" </mark> </h5> <h5 class='d-inline px-3'  style='font-family:helvetica; font-weight:bold; '>  <mark class='d-inline-flex pb-2' style='background-color:white; border-radius:5px;'> <p class='d-inline-flex' style='font-size:16px; font-weight:lighter' > Deceased ► </p> "+file.deceased+"</mark> <mark class='d-inline-flex' style='background-color:grey; color:white; border-radius:5px;'>▲"+daily.deceased+" </mark> </h5> <h5 class='d-inline px-3'  style='font-family:helvetica; font-weight:bold; '>  <mark class='d-inline-flex pb-2' style='background-color:white; border-radius:5px;'> <p class='d-inline-flex' style='font-size:16px; font-weight:lighter' > Recovery Rate ► </p> "+recovery+"</mark></h5>  	</div>")

		        

		        }
    		        
        
		    });
        	
		});	    
        		    
        		    
        		    


</script>
@endsection