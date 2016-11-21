<?php
/*
 * Following code will create a new product row
 * All product details are read from HTTP Post Request
 */
error_reporting(E_ALL ^ E_NOTICE);
include "mysql.php";
$connection = new createCon();
$connection->connect();

header('Access-Control-Allow-Origin: *');

// array for JSON response
$response = array();

//$json = file_get_contents('php://input');
//$obj = json_decode($json, true);
//$taxon = $obj['taxon'];



    if(isset($_POST['blumen']))
    {
        
       $jsonObj= json_decode($_POST['blumen'], true);
      // foreach($jsonObj as $j)
       //{
        //$fundpunktNr = $jsonObj->fundpunktNr;
        //$insel = $jsonObj->insel;
       foreach($jsonObj as $key){
        $fundpunktNr = $key['fundpunktNr'];
        $insel = $key['insel'];
       
       //}s
       
    // mysql inserting a new row
    //$result = "INSERT INTO b_beobachter(b_name,b_kuerzel) VALUES('$fundpunktNr', '$insel')";
    $result = "INSERT INTO ku_kult(ku_kultnr,ku_anmerkung) VALUES('$fundpunktNr', '$insel')";
    $result2 = mysqli_query($connection->myconn, $result);
       }
       if ($result2) {
        // successfully inserted into database
        //$response["success"] = 1;
        //$response["message"] = "Product successfully created.";
        // echoing JSON response
        //echo json_encode($response);
        echo 'BlumeOK';
    } else {
        
        echo 'BlumenERROR';
    }
    }
       
    if(isset($_POST['login']))
    {
       $jsonObj= json_decode($_POST['login'], true);
      // foreach($jsonObj as $j)
       //{
        //$fundpunktNr = $jsonObj->fundpunktNr;
        //$insel = $jsonObj->insel;
       foreach($jsonObj as $key){
        $user = $key['user'];
        $pw = $key['pw'];
       
       //}
       
    $result = "SELECT b_name, b_kuerzel FROM b_beobachter WHERE b_name LIKE '$user' LIMIT 1";
    $result2 = mysqli_query($connection->myconn, $result);
    $row = mysqli_fetch_object($result2);
    
    if ($row == true && $row->b_kuerzel == $pw) {
        echo 'LoginOK';
    }
    else
    {
        echo 'LoginERROR';
    }
       }

    }
    ?>
    