<?php
//----------------------------------------------------------------------------//
/// Vérifier si le mdp correspond au USER envoyé qui doit aussi existé /////////
//----------------------------------------------------------------------------//
function getMDPUser($user,$mdp){
    $listemdp= array(
        "administrateur"=>"iutinfo",
        "teo"=>"mdpteo",
        "arthur"=>"mdparthur");
    $usermdp=array($user=>$mdp);
    if(in_array($usermdp,$listemdp)) {
        return TRUE;
    } else {
        return FALSE;
    }
}
//---------------------------------------------//
/// Retourner le rôle de l'utilisateur /////////
//--------------------------------------------//
function getRole($user){
    $listerole= array(
        "administrateur"=>"ADMIN",
        "teo"=>"PUBLISHER",
        "arthur"=>"PUBLISHER");
    if(in_array($user,$listerole)) {
        return $listerole[$user];
    } else {
        return "VISITEUR";
    }
}
?>