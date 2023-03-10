<?php
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
//-------------------------------------------------------//
//////////////////  ROLE non Authentifié       ////////////
//-------------------------------------------------------//
//-------------------------------------------------------//
////////////////// Cas des méthodes GET  //////////////////
//-------------------------------------------------------//
function GETMethod($id=null){
    $lien='http://localhost/R401/APIREST/SERVERAPI.php';
    if(is_null($id)){
        $result = file_get_contents($lien,false
        ,stream_context_create(array('http' => array('method' => 'GET'))) 
        );
    } else {
        $result = file_get_contents($lien."?id=".$id,false
        ,stream_context_create(array('http' => array('method' => 'GET'))) 
        );
    }
    $result = json_decode($result,true);
    return $result;
}
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
//-------------------//
// POUR VERIFIER LES ERREURS AVEC JSON
//echo json_last_error()." // ".json_last_error_msg();
//var_dump($result);
//-------------------//
?>