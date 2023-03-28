<?php
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
require_once("./DAO/functionUser.php");
require_once("./Fonction/functionCLIENT.php");
require_once("./Fonction/jwt_utils.php");
echo "</br>-----------------------<br/>";
echo insertUser("Teo","\$iutinfo","1");
echo insertUser("Arthur","\$iutinfo","1");
echo insertUser("Nicolas","jadoreleschats","2");
echo insertUser("Elena","jadoreleschevaux","2");
echo insertUser("Fantin","jadorelesjeux","2");
echo "</br>-----------------------</br>";
//$reponse= CONNEXION("Teo","\$iutinfo");
$reponse= CONNEXION("Nicolas","jadoreleschats");
$token = $reponse["data"];
echo $token;
echo "</br>-----------------------</br>";
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
?>