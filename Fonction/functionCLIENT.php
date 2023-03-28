<?php
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
//-------------------------------------------------------------//
////////////////// CONNEXION AU SERVER / TOKEN //////////////////
//-------------------------------------------------------------//
function CONNEXION($login,$mdp){
    $lien='http://localhost/R401/APIREST/API/SERVERAUTH.php';
    $data = array("login"=>$login,"mdp" =>$mdp);
    $data_string = json_encode($data);
    $token=file_get_contents(
        $lien,false,
        stream_context_create(array(
        'http' => array('method' => 'POST',
        'content' => $data_string,
        'header' => array('Content-Type: application/json'."\r\n"
        .'Content-Length: '.strlen($data_string)."\r\n"))))
    );
    $reponse = json_decode($token,true);
    return $reponse;
}
//-------------------------------------------------------------//
////////////////// Cas des méthodes GET TOKEN  //////////////////
//-------------------------------------------------------------//
function GETArticleTOKEN($token,$id=null){
    $lien='http://localhost/R401/APIREST/SERVERAPI.php';
    if(is_null($id)){
        $result = file_get_contents($lien,false,
        stream_context_create(array('http' => array('method' => 'GET','header'=>'Authorization: Bearer '.$token))) 
        );
    } else {
        $result = file_get_contents($lien."?id=".$id,false,
        stream_context_create(array('http' => array('method' => 'GET','header'=>'Authorization: Bearer '.$token))) 
        );
    }
    $result = json_decode($result,true);
    return $result;
}
//-------------------------------------------------------------//
////////////////// Cas des méthodes GET        //////////////////
//-------------------------------------------------------------//
function GETArticle($id=null){
    $lien='http://localhost/R401/APIREST/SERVERAPI.php';
    if(is_null($id)){
        $result = file_get_contents($lien,false,
        stream_context_create(array('http' => array('method' => 'GET'))) 
        );
    } else {
        $result = file_get_contents($lien."?id=".$id,false,
        stream_context_create(array('http' => array('method' => 'GET'))) 
        );
    }
    $result = json_decode($result,true);
    return $result;
}
//-------------------------------------------------------------//
//////////////////        GET My Article       //////////////////
//-------------------------------------------------------------//
function GETMyArticle($pseudo,$token){
    $lien='http://localhost/R401/APIREST/SERVERAPI.php?pseudo='.$pseudo;
    $result = file_get_contents($lien,false,
    stream_context_create(array('http' => array('method' => 'GET','header' => array('Authorization: Bearer '.$token)))) 
    );
    $result = json_decode($result,true);
    return $result;
}
//-------------------------------------------------------------//
////////////////// Ajout de like ou dislike    //////////////////
//-------------------------------------------------------------//
function INSERTLikeDislike($token,$id_art,$like){
    $lien='http://localhost/R401/APIREST/SERVERAPI.php';
    $data = array("id_art"=>$id_art,"like"=>$like);
    $data_string = json_encode($data);
    /// Envoi de la requête
    $post=file_get_contents(
        $lien,false,
        stream_context_create(array(
        'http' => array('method' => 'POST',
        'content' => $data_string,
        'header' => array('Authorization: Bearer '.$token,'Content-Type: application/json'."\r\n"
        .'Content-Length: '.strlen($data_string)."\r\n"))))
    );
    $reponsepost = json_decode($post,true);
    return $reponsepost;
}
//-------------------------------------------------------------//
////////////////// Ajout d'article             //////////////////
//-------------------------------------------------------------//
function INSERTArticle($token,$contenu,$titre){
    $lien='http://localhost/R401/APIREST/SERVERAPI.php';
    $data = array("contenu"=>$contenu,"titre"=>$titre);
    $data_string = json_encode($data);  
    /// Envoi de la requête
    $post=file_get_contents(
        $lien,false,
        stream_context_create(array(
        'http' => array('method' => 'POST',
        'content' => $data_string,
        'header' => array('Authorization: Bearer '.$token,'Content-Type: application/json'."\r\n"
        .'Content-Length: '.strlen($data_string)."\r\n"))))
    );
    $reponsepost = json_decode($post,true);
    return $reponsepost;
}
//-------------------------------------------------------------//
////////////////// Modification d'article      //////////////////
//-------------------------------------------------------------//
function MODIFArticle($token,$contenu,$titre,$id_art){
    $lien='http://localhost/R401/APIREST/SERVERAPI.php';
    $data = array("contenu"=>$contenu,"titre"=>$titre,"id_art"=>$id_art);
    $data_string = json_encode($data);
    /// Envoi de la requête
    $patch=file_get_contents(
        $lien,false,
        stream_context_create(array(
        'http' => array('method' => 'PUT',
        'content' => $data_string,
        'header' => array('Authorization: Bearer '.$token,'Content-Type: application/json'."\r\n"
        .'Content-Length: '.strlen($data_string)."\r\n"))))
    );
    $reponsepatch = json_decode($patch,true);
    return $reponsepatch;
}
//-------------------------------------------------------------//
////////////////// Suppression  d'article      //////////////////
//-------------------------------------------------------------//
function DELETEArticle($id,$token){
    $lien='http://localhost/R401/APIREST/SERVERAPI.php';
    $deleteadmin = file_get_contents($lien.'?id='.$id,false,
    stream_context_create(array('http' => array('method' => 'DELETE','header'=>'Authorization: Bearer '.$token))) 
    );
    $responsedeleteadmin = json_decode($deleteadmin,true);
    return $responsedeleteadmin;
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