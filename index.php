<?php
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
require_once("./DAO/functionUser.php");
require_once("./DAO/functionSERVER.php");
echo "</br>-----------------------<br/>";
echo insertUser("Teo","\$iutinfo","1");
echo insertUser("Arthur","\$iutinfo","1");
echo insertUser("Nicolas","jadoreleschats","2");
echo insertUser("Elena","jadoreleschevaux","2");
echo insertUser("Fantin","jadorelesjeux","2");
echo "</br>-----------------------</br>";
$data = array("login"=>"Nicolas","mdp" =>"jadoreleschats");
$data_string = json_encode($data);
/// Envoi de la requête
$token=file_get_contents(
    'http://localhost/R401/APIREST/API/SERVERAUTH.php',
    false,
    stream_context_create(array(
    'http' => array('method' => 'POST',
    'content' => $data_string,
    'header' => array('Content-Type: application/json'."\r\n"
    .'Content-Length: '.strlen($data_string)."\r\n"))))
);
$reponse = json_decode($token,true);
$token = $reponse["data"];
echo $token;
echo "</br>-----------------------</br>";
// $data = array("pseudo"=>"Nicolas","contenu"=>"Salut c\'est moi","titre"=>"Saucisse");
// $data_string = json_encode($data);
// /// Envoi de la requête
// $post=file_get_contents(
//     'http://localhost/R401/APIREST/API/SERVERAPI.php',
//     false,
//     stream_context_create(array(
//     'http' => array('method' => 'POST',
//     'content' => $data_string,
//     'header' => array('Authorization: Bearer '.$token,'Content-Type: application/json'."\r\n"
//     .'Content-Length: '.strlen($data_string)."\r\n"))))
// );
// $reponsepost = json_decode($post,true);
// print_r($reponsepost);
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
?>