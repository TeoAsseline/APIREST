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
if(password_verify("jadoreleschats",getMdp("Nicolas"))==false){
    echo "pas le meme";
} else {
    echo "le meme";
}
echo "</br>-----------------------</br>";
echo ifMDPUser("slt","bon");
echo ifMDPUser("Nicolas","jadoreleschats");
// $data = array("login"=>"Nicolas","mdp" =>"jadoreleschats");
// $data_string = json_encode($data);
// /// Envoi de la requête
// $token=file_get_contents(
// 'http://localhost/R401/APIREST/API/SERVERAUTH.php',
// null,
// stream_context_create(array(
// 'http' => array('method' => 'POST',
// 'content' => $data_string,
// 'header' => array('Content-Type: application/json'."\r\n"
// .'Content-Length: '.strlen($data_string)."\r\n"))))
// );
// $token = json_decode($token,true);
// print_r($token);
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
?>