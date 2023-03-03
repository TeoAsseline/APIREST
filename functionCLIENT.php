<?php
//-------------------//
// POUR VERIFIER LES ERREURS AVEC JSON
//echo json_last_error()." // ".json_last_error_msg();
//var_dump($result);
//-------------------//

//-------------------------------------------------------//
////////////////// Cas des méthodes GET  //////////////////
//-------------------------------------------------------//
function TEST($id=null){
    if(is_null($id)){
        $result = file_get_contents('http://localhost/R401/TPRESTCHUCK/CHUCKPERSO/APIRESTperso.php',
        false,
        stream_context_create(array('http' => array('method' => 'GET'))) 
        );
    } else {
        $result = file_get_contents('http://localhost/R401/TPRESTCHUCK/CHUCKPERSO/APIRESTperso.php?id='.$id,
        false,
        stream_context_create(array('http' => array('method' => 'GET'))) 
        );
    }
    $result = json_decode($result,true);
    return $result;
}
//-------------------------------------------------------//
////////////////// Cas des méthodes GET  //////////////////
//-------------------------------------------------------//
?>