<?php

function CalculateSun(){
    
    //Use either API or PHP function
    //Use: "API" | "PHP"
    $calcMethod = "PHP";

    //gets set when response has arrived
    $result = null;

    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $date = $_POST['date'];

    //var_dump($date);

    if(empty($latitude) || empty($longitude)){
        echo"Inputs can't be empty";
        //Stop function early if input is empty
        return;
    }

    
    //$latitude = filter_input(INPUT_POST, 'latitude', FILTER_SANITIZE_SPECIAL_CHARS);
    //$latitude = filter_input(INPUT_POST, 'latitude', FILTER_SANITIZE_NUMBER_FLOAT);

    if(!validateInput($latitude, 'latitude') || !validateInput($longitude, 'longitude')){
        echo "Input has to be valid coordinates";
        return;
    }

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
        //Needs allow fraction to keep the decimal
        $sanitizedInput = filter_input(INPUT_POST, $InputName, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        if(filter_var($sanitizedInput, FILTER_VALIDATE_FLOAT) !== false){
            return true;
        }
        return false;
    }

    //Function for using the API from sunrisesunset.io
    function CalculateSunUsingAPI($latitude, $longitude, $date){
        try{
            $ch = curl_init();
            $date = $date;

            if (empty($date)){
                $date = date("y-m-d");
            }

            curl_setopt($ch, CURLOPT_URL, 'https://api.sunrisesunset.io/json?lat='. $latitude .'&lng='. $longitude .'&time_format=24&date=' . $date);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_response = curl_exec($ch);

            curl_close($ch);

            $server_response = json_decode($server_response, true);
        } catch (Exception $e){
            echo"Error: {$e}";
        }


        if(isset($server_response["results"])){
            $result = $server_response["results"];
        }else {
            //Fucntion stops here.
            echo("Error when fetching data");
            return;
        }

        //echo $server_response["results"]["sunrise"];
        if(isset($result)){
            $sunrise = $server_response["results"]["sunrise"];
            $sunset = $server_response["results"]["sunset"];
            echo("<p>Sunrise: {$sunrise}</p><p>Sunset: {$sunset}</p>");
        }
    }

    //Function for using PHP built in function.
    function CalculateSunUsingPHP(float $latitude, float $longitude, $date){
        $sunrise="";
        $sunset="";

        $date=$date;

        if(empty($date)){
            $date=time();
        }else{
            $date=strtotime($date);
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