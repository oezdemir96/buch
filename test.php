<?php
error_reporting(E_ALL ^ E_NOTICE);
include "mysql.php";
$connection = new createCon();
$connection->connect();

header('Access-Control-Allow-Origin: *');

include("vendor/autoload.php");
use proj4php\Proj4php;
use proj4php\Proj;
use proj4php\Point;
 
// Initialise Proj4
$proj4 = new Proj4php();
 
// Definition für WGS 84 / UTM zone 34N
$proj4->addDef("EPSG:25834",'+proj=utm +zone=34 +ellps=WGS84 +datum=WGS84 +units=m +no_defs');
 
// Create two different projections.
$projUTM     = new Proj('EPSG:25834', $proj4);
$projWGS84     = new Proj('EPSG:4326', $proj4);
 
// Create a point.
//$pointSrc = new Point(20.64405902, 38.58693501, $projWGS84);


// array for JSON response
$response = array();

//if(isset($_POST['blumen']))
  // {

   // $jsonObj= json_decode($_POST['blumen']);
  
       //$kultnr = $jsonObj->kultnr;
       
       //$kultAnm = $jsonObj->kultAnm;
       
       //$fundpunktNr = $jsonObj->fundpunktNr;
      // $fundortKurz= $jsonObj->fundortKurz; 
      // $fundorfgenau= $jsonObj->fundortGenau;
      // $habitat= $jsonObj->habitat;
      // $nomos=$jsonObj->nomos;
      // $anmFundpunkt= $jsonObj->fundpunktNr;
    
       //Point
       $easting = 21;
       //$easting = $jsonObj->easting;
       $northing= 37.25354911;
       //$easting = $jsonObj->easting;
       
       //Kult
       $kultnr = "LOL";
       
       $kultAnm = "LEL";
       
       //Fundpunkt
       $fundpunktNr = "25";
       $fundortKurz= "fundkurz"; 
       $fundorfgenau= "fundGenau";
       $habitus= "habitus";
       $nomos="nom";
       $anmFundpunkt= "anmFu";
       $ungenauigkeit= "ungenauigkeit";
       $spinner="spinner";
       $spinner2="spinner2";
       $anmDatum="anmDatum";
       $year="2012";
       $month="12"; 
       $day="02";
       $fp_datevon="$year-$month-$day";
       $year2="2015";
       $month2="11";
       $day2= "01"; 
       $fp_datebis="$year2-$month2-$day2";
       
       
       //Herbar
      
       $herbarNr= "5"; 
       $anmHerbar= "anmHerb";
       

       //Eintrag
       $taxonAnm= "taxonAnm";
       $link= "link";
       $lit="0";
       $paldat="0";
       $foto="0";
       $fotoDig="fotoDigi";
       $habitat= "habitat";
       $herbarium= "0";
       
       //Status
       $typ="typ";
       
       
      //insel
      $insl = "Atokos";  

      //Taxon
      $taxon="Abutilon theophrasti";
      
      //Beobachtet
      $beobacht= "Rita";
      
      //Überprüft
      $prvtVon="Rita"; 
      
      //herbariumeintrag
      $sammelNr="1";
      
      //Literatureintrag
      $werk="95For";
      $seiten="seiten";
      $litherbar="0";
      $taxonGenannt="taxonGenannt"; 
      
      
      


$koordN = 48.4526; 
$koordE = 13.437;
       
$pointSrc = new Point($easting, $northing, $projWGS84);
 
// Transform the point between datums.
$pointDest = $proj4->transform($projUTM, $pointSrc)->toArray();
$utmRightRounded = round($pointDest[0],0);
$utmHeightRounded = round($pointDest[1],0);
echo "Conversion (UTM_RIGHT, UTM_HEIGHT): {$utmRightRounded}, {$utmHeightRounded}\n";
echo '<br>';

$pointSrc2 = new Point($koordE, $koordN, $projWGS84);
 
// Transform the point between datums.
$pointDest2 = $proj4->transform($projUTM, $pointSrc2)->toArray();
$utmRightRounded2 = round($pointDest2[0],0);
$utmHeightRounded2 = round($pointDest2[1],0);
echo "Conversion (UTM_RIGHT, UTM_HEIGHT): {$utmRightRounded2}, {$utmHeightRounded2}\n";
echo '<br>';


        $sql0 = "INSERT INTO p_point(p_pnt, p_format, p_genauigkeit) VALUES (GeomFromText('POINT($utmRightRounded2 $utmHeightRounded2)'),'utm','10km')";
        $result0 = mysqli_query($connection->myconn, $sql0);
        $sql01 = "SELECT p_id FROM `p_point` WHERE X(p_pnt)=$utmRightRounded2 AND Y(p_pnt)=$utmHeightRounded2";
        $result01 = mysqli_query($connection->myconn, $sql01);
        $row01 = mysqli_fetch_object($result01);
        if($row01 == true){
            $fp_p_id = $row01->p_id;
            echo "fp_p_id=$fp_p_id";
            echo '<br>';
        }

       $sql1 = "INSERT INTO ku_kult(ku_kultnr,ku_anmerkung) VALUES ('$kultnr','$kultAnm')";
       $result1 = mysqli_query($connection->myconn, $sql1);
       $sql2 = "SELECT p_id FROM `p_point` WHERE X(p_pnt)=500000 AND Y(p_pnt)=4123000";
       $result2 = mysqli_query($connection->myconn, $sql2);
       $row2 = mysqli_fetch_object($result2);
       if($row2 == true){
            $km_p_id=$row2->p_id;
            echo "km_p_id=$km_p_id";
            echo '<br>';
            
             $sql3 = "SELECT km_id FROM km_kmfelder WHERE km_p_utm='$km_p_id'";
             $result3 = mysqli_query($connection->myconn, $sql3);
             $row3 = mysqli_fetch_object($result3);
             $sql4 = "SELECT i_id FROM i_insel  WHERE i_insel='$insl'";
             $result4 = mysqli_query($connection->myconn, $sql4);
             $row4 = mysqli_fetch_object($result4);
        if($row4 == true){
           $fp_i_id = $row4->i_id;
           echo "fp_i_id=$fp_i_id";
           echo '<br>';
        }
        else
        {
            echo 'kein InselId';
        }
             
       if($row3 == true){
           $fp_km_id =  $row3->km_id;
           echo "fp_km_id=$fp_km_id";
           echo '<br>';
           
           $sql5="INSERT INTO `fp_fundpunkt` (`fp_fundpunktnr`,`fp_fundpunkt_kurz` ,`fp_fundpunkt_lang` ,`fp_habitat` ,`fp_nomos` ,`fp_anmerkung` ,`fp_i_id`,`fp_km_id`, `fp_hoehev`, `fp_hoeheb`, `fp_genauigkeit`, `fp_p_id`, `fp_dateanmerkung`, `fp_datevon`, `fp_datebis`) "
                   . "VALUES (null, '$fundortKurz', '$fundorfgenau', '$habitat', '$nomos', '$anmFundpunkt', '$fp_i_id', '$fp_km_id', '$spinner', '$spinner2', '$ungenauigkeit' , '$fp_p_id', '$anmDatum', '$fp_datevon' , '$fp_datebis')";
           $result5 = mysqli_query($connection->myconn, $sql5);
           if(result5 == true)
           {
               echo 'FUNDPUNKT ERFOLGREICH HINZUGEFÜGT';
               echo '<br>';
           }

       }
       }
       
       $sql6 = "INSERT INTO h_herbar(h_name, h_herbnr, h_anmerkung) VALUES ('herbar', '$herbarNr', '$anmHerbar')";
       $result6 = mysqli_query($connection->myconn, $sql6);
       if($result6 == true)
       {
           echo 'HERBAR ERFOLGREICH HINZUGEFÜGT';
           echo '<br>';
       }
       
        $sql02 = "SELECT ku_id FROM ku_kult WHERE ku_anmerkung='$kultAnm' LIMIT 1";
           $result02 = mysqli_query($connection->myconn, $sql02);
           $row02 = mysqli_fetch_object($result02);
        $sql03 = "SELECT fp_id from fp_fundpunkt WHERE fp_fundpunkt_kurz='$fundortKurz' LIMIT 1";   
          $result03 = mysqli_query($connection->myconn, $sql03);
           $row03 = mysqli_fetch_object($result03); 
           $sql04 = "SELECT t_taxid from t_taxon WHERE t_taxname_ges='$taxon' LIMIT 1";   
          $result04 = mysqli_query($connection->myconn, $sql04);
           $row04 = mysqli_fetch_object($result04); 
        if($row02 == true){  
               $ekuid=$row02->ku_id;
               echo "ekuid=$ekuid";
           echo '<br>';
        }
         if($row03 == true){  
               $efpid=$row03->fp_id;
               echo "efpid=$efpid";
           echo '<br>';
         }
         if($row04 == true){  
               $etid=$row04->t_taxid;
               echo "etid=$etid";
           echo '<br>';
         }
       
       $sql7 = "INSERT into e_eintrag (e_eintragsnr, e_ku_id, e_f_id, e_t_id, e_taxonanmerkung, e_habitat,e_status,e_foto,e_paldat,e_lit,e_herbar,e_fotodigitalisiert,e_link,e_fp_id) 
       Values(NULL, '$ekuid',NULL, '$etid', '$taxonAnm', '$habitat', '$typ','$foto','$paldat','$lit','$herbarium','$fotodig','$link','$efpid')"; 
        $result7 = mysqli_query($connection->myconn, $sql7);
       if($result7 == true)
       {
           echo 'EINTRAG ERFOLGREICH HINZUGEFÜGT';
           echo '<br>';
       }
           
       
       $sql8 = "SELECT b_id FROM b_beobachter WHERE b_name='$beobacht'";
       $result8=  mysqli_query($connection->myconn, $sql8);
       $row7 = mysqli_fetch_object($result8); 
         if($row7 == true){  
               $bebid=$row7->b_id;
               echo "bebid=$bebid";
           echo '<br>';
         }
        
         
       $sql9 = "SELECT e_id from e_eintrag WHERE e_fp_id='$efpid' LIMIT 1";
       $result9=  mysqli_query($connection->myconn, $sql9);
       $row9 = mysqli_fetch_object($result9); 
       
         if($row9 == true){  
               $ueeid=$row9->e_id;
               echo "ueeid=$ueeid";
           echo '<br>';
         }
         
       $sql10 = "INSERT INTO ue_ueberprueft(ue_b_id, ue_e_id) VALUES ('$bebid','$ueeid' )";
       $result10 = mysqli_query($connection->myconn, $sql10);
       if($result10 == true)
       {
           echo 'ÜBERPRÜFT ERFOLGREICH HINZUGEFÜGT';
           echo '<br>';
       }
          
         
       $sql11 = "INSERT INTO be_beobachtet(be_b_id, be_f_id) VALUES ('$bebid', '$efpid')";
       $result11 = mysqli_query($connection->myconn, $sql11);
       if($result11 == true)
       {
           echo 'BEOBACHTET ERFOLGREICH HINZUGEFÜGT';
           echo '<br>';
       }
       
       
       
       
       $sql12 = "SELECT h_id from  h_herbar WHERE h_herbnr='$herbarNr' LIMIT 1";
       $result12=  mysqli_query($connection->myconn, $sql12);
       $row12 = mysqli_fetch_object($result12); 
       
         if($row12 == true){  
               $hehid=$row12->h_id;
               echo "hehid=$hehid";
           echo '<br>';
         }
         
       $sql13 = "INSERT INTO he_herbariumeintrag(he_e_id, he_h_id, he_duplnr) VALUES ('$ueeid','$hehid', '$sammelNr')";
       $result13 = mysqli_query($connection->myconn, $sql13);
       if($result13 == true)
       {
           echo 'HERBARIUMEINTRAG ERFOLGREICH HINZUGEFÜGT';
           echo '<br>';
       }
       
       $sql14 = "SELECT l_id from  l_literatur WHERE l_werk_kurz='$werk' LIMIT 1";
       $result14 =  mysqli_query($connection->myconn, $sql14);
       $row14 = mysqli_fetch_object($result14); 
       
         if($row14 == true){  
               $lelid=$row14->l_id;
               echo "lelid=$lelid";
           echo '<br>';
         }
         
       $sql15 = "INSERT INTO le_literatureintrag(le_l_id, le_e_id, le_seiten, le_genannt_als, le_anmerkung, le_litherbar) VALUES ('$lelid','$ueeid', '$seiten', '$taxonGenannt', NULL, '$litherbar')";
       $result15 = mysqli_query($connection->myconn, $sql15);
       if($result15 == true)
       {
           echo 'Literauteintrag ERFOLGREICH HINZUGEFÜGT';
           echo '<br>';
       }
          
    
     
    
    ?>

       
   
    
    
    