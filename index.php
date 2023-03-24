<?php
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
require_once("./DAO/functionUser.php");
require_once("./DAO/functionSERVER.php");
require_once("./Fonction/jwt_utils.php");
echo "</br>-----------------------<br/>";
echo insertUser("Teo","\$iutinfo","1");
echo insertUser("Arthur","\$iutinfo","1");
echo insertUser("Nicolas","jadoreleschats","2");
echo insertUser("Elena","jadoreleschevaux","2");
echo insertUser("Fantin","jadorelesjeux","2");
echo "</br>-----------------------</br>";
//$data = array("login"=>"Nicolas","mdp" =>"jadoreleschats");
$data = array("login"=>"Teo","mdp" =>"\$iutinfo");
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
// ajout de like or dislike
// $data = array("id_art"=>1,"like"=>1);
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

// ajout d'article
// $data = array("contenu"=>"Le cheval, le cheval c'est trop génial","titre"=>"Cheval");
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

// modification article
// $data = array("pseudo"=>"Nicolas","contenu"=>"en faite c\'est pas moi","titre"=>"Baguette","id_art"=>1);
// $data_string = json_encode($data);
// /// Envoi de la requête
// $patch=file_get_contents(
//     'http://localhost/R401/APIREST/API/SERVERAPI.php',
//     false,
//     stream_context_create(array(
//     'http' => array('method' => 'PUT',
//     'content' => $data_string,
//     'header' => array('Authorization: Bearer '.$token,'Content-Type: application/json'."\r\n"
//     .'Content-Length: '.strlen($data_string)."\r\n"))))
// );
// $reponsepatch = json_decode($patch,true);
// print_r($reponsepatch);

//delete admin article
// $id=1;
// $deleteadmin = file_get_contents('http://localhost/R401/APIREST/API/SERVERAPI.php?id='.$id,
//     false,
//     stream_context_create(array('http' => array('method' => 'DELETE','header'=>'Authorization: Bearer '.$token))) 
//     );
//     $responsedeleteadmin = json_decode($deleteadmin,true);
//     print_r($responsedeleteadmin);

//delete publisher article
// $id=2;
// $pseudo="Fantin";
// $deletepublisher = file_get_contents('http://localhost/R401/APIREST/API/SERVERAPI.php?id='.$id.'&pseudo='.$pseudo,
//     false,
//     stream_context_create(array('http' => array('method' => 'DELETE','header'=>'Authorization: Bearer '.$token))) 
//     );
//     $responsedeletepublisher = json_decode($deletepublisher,true);
//     print_r($responsedeletepublisher);

//récupérer un article token
// $id=1;
// $getOneArticle = file_get_contents('http://localhost/R401/APIREST/API/SERVERAPI.php?id='.$id,
//         false,
//         stream_context_create(array('http' => array('method' => 'GET','header' => array('Authorization: Bearer '.$token)))) 
//         );
//         $responsegetone = json_decode($getOneArticle,true);
//         print_r($responsegetone);

//récupérer les articles token
// $getAllArticle = file_get_contents('http://localhost/R401/APIREST/API/SERVERAPI.php',
//         false,
//         stream_context_create(array('http' => array('method' => 'GET','header' => array('Authorization: Bearer '.$token)))) 
//         );
//         $responsegetAll = json_decode($getAllArticle,true);
//         print_r($responsegetAll);

//récupérer un article
// $pseudo="Nicolas";
// $getmyArticle = file_get_contents('http://localhost/R401/APIREST/API/SERVERAPI.php?pseudo='.$pseudo,
//         false,
//         stream_context_create(array('http' => array('method' => 'GET','header' => array('Authorization: Bearer '.$token)))) 
//         );
//         $responsegetmy = json_decode($getmyArticle,true);
//         print_r($responsegetmy);

//récupérer un article non auth
// $id=1;
// $getOneArticle = file_get_contents('http://localhost/R401/APIREST/API/SERVERAPI.php?id='.$id,
//         false,
//         stream_context_create(array('http' => array('method' => 'GET'))) 
//         );
//         $responsegetone = json_decode($getOneArticle,true);
//         print_r($responsegetone);

//récupérer les articles non auth
// $getAllArticle = file_get_contents('http://localhost/R401/APIREST/API/SERVERAPI.php',
//         false,
//         stream_context_create(array('http' => array('method' => 'GET'))) 
//         );
//         $responsegetAll = json_decode($getAllArticle,true);
//         print_r($responsegetAll);

//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
?>