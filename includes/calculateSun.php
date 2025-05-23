<?php

function CalculateSun(){
    
    //Use either API or PHP function
    //Use: "API" | "PHP"
    $calcMethod = "API";

    //gets set when response has arrived
    $latitude = null;
    $longitude = null;
    $date = null;

    if(isset($_POST['latitude'])){
        $latitude = $_POST['latitude'];
    };
    if(isset($_POST['longitude'])){
        $longitude = $_POST['longitude'];
    };
    if(isset($_POST['date'])){
        $date = $_POST['date'];
    }else{
        //If no date is set, create unix for current time;
        $date = time();
    };


    if(empty($latitude) || empty($longitude)){
        echo"Inputs can't be empty";
        //Stop function early if input is empty
        return;
    }

    //validates if inputs have correct data. Calls validateInput function
    if(!validateInput($latitude, 'latitude') || !validateInput($longitude, 'longitude')){
        echo "Input has to be valid coordinates";
        return;
    }

    //Method for calculation is set on top of this script.
    if ($calcMethod == "API"){
        CalculateSunUsingAPI($latitude, $longitude, $date);
    }else if ($calcMethod == "PHP"){
        CalculateSunUsingPHP($latitude, $longitude, $date);
    }else {
        echo"Invalid Calculation Method Selected, (Use either 'API' OR 'PHP')";
    }


}

    //Validates if given inputs could be valid coords.
    function validateInput($DataToValidate, string $InputName){
        //Needs allow fraction to keep the decimal (FILTER_FLAG_ALLOW_FRACTION)
        $sanitizedInput = filter_input(INPUT_POST, $InputName, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        if(filter_var($sanitizedInput, FILTER_VALIDATE_FLOAT)){
            return true;
        }
        return false;
    }

    //Function for using the API from sunrisesunset.io
    function CalculateSunUsingAPI($latitude, $longitude, $date){
        //Tries to do the API call.
        try{
            $ch = curl_init();
            $date = $date;

            if (empty($date)){
                $date = date("Y-m-d");
            }
            
            curl_setopt($ch, CURLOPT_URL, 'https://api.sunrisesunset.io/json?lat='. $latitude .'&lng='. $longitude .'&time_format=24&date=' . $date);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_response = curl_exec($ch);

            curl_close($ch);

            $server_response = json_decode($server_response, true);
        } catch (Exception $e){
            echo"Error: {$e}";
        }

        //Maybe the API call returned data, but not what looking for. For example if the API have updated ect.
        if(isset($server_response["results"])){
            $result = $server_response["results"];
        }else {
            //If the data is not found, stop function here.
            echo("Error when fetching data");
            return;
        }

        //Checks for if the value is empty.
        if(!empty($result)){
            $sunrise = $server_response["results"]["sunrise"];
            $sunset = $server_response["results"]["sunset"];
            echo("<p>Sunrise: {$sunrise}</p><p>Sunset: {$sunset}</p>");
        }
    }

    //Function for using PHP built in function.
    function CalculateSunUsingPHP(float $latitude, float $longitude, $date){
        $sunrise="";
        $sunset="";

        //Handle if the date is set or not set in the app.
        if(!empty($date))
        {
            $date=strtotime($date);
        }else{
            $date=time();
        }

        
        if(isset($latitude)|| isset($longitude)){
            $sunrise = date_sunrise($date, SUNFUNCS_RET_STRING, $latitude, $longitude);
            $sunset = date_sunset($date, SUNFUNCS_RET_STRING, $latitude, $longitude);
        }else{
            //Should not be possible to call this function without input values, but in case:
            $sunrise = date_sunrise($date, SUNFUNCS_RET_STRING);
            $sunset = date_sunset($date, SUNFUNCS_RET_STRING);
        }
        
        echo("<p>Sunrise: {$sunrise}</p><p>Sunset: {$sunset}</p>");
    }

    if(isset($_POST['submitBtn'])){
        CalculateSun();
    }
?>