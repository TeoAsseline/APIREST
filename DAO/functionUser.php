<?php
require_once("BDD.php");
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
//----------------------------------------------------------------------------//
/// Vérifier si le mdp correspond au USER envoyé qui doit aussi existé /////////
//----------------------------------------------------------------------------//
function ifMDPUser($pseudo,$mdp){
    $linkpdo=ConnexionBDD();
    if (password_verify($mdp,getMdp($pseudo))) {
        $req = $linkpdo->prepare("SELECT pseudo,mdp FROM users where pseudo=:pseudo and mdp=:mdp");
        $req->execute(array(":pseudo"=>$pseudo,":mdp"=>$mdp));
        if($req->rowCount() > 0){
            return TRUE;
        } else {
            return FALSE;
        }
    } else {
        return FALSE;
    }
}
//---------------------------------------------//
/// Retourner le rôle de l'utilisateur /////////
//--------------------------------------------//
function getRole($pseudo){
    $linkpdo=ConnexionBDD();
    $req = $linkpdo->prepare("SELECT role FROM users where pseudo=:pseudo");
    $req->execute(array(":pseudo"=>$pseudo));
    if($req->rowCount() > 0){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data[0]["role"];
    } else {
        return "ERROR";
    }
}
//-----------------------------------------------//
/// Retourner l'id du user par son Pseudo /////////
//-----------------------------------------------//
function getIdByPseudo($pseudo){
    $linkpdo=ConnexionBDD();
    $req = $linkpdo->prepare("SELECT id_user FROM users where pseudo=:pseudo");
    $req->execute(array(":pseudo"=>$pseudo));
    if($req->rowCount() > 0){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data[0]["id_user"];
    } else {
        return "ERROR";
    }
}
//---------------------------------------------//
/// Retourner le mdp  de l'utilisateur /////////
//--------------------------------------------//
function getMdp($pseudo){
    $linkpdo=ConnexionBDD();
    $req = $linkpdo->prepare("SELECT mdp FROM users where pseudo=:pseudo");
    $req->execute(array(":pseudo"=>$pseudo));
    if($req->rowCount() > 0){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data[0]["mdp"];
    } else {
        return "ERROR";
    }
}
//---------------------------------------------------//
/// Retourner si user existe dans l'appliction ////////
//---------------------------------------------------//
function ifUser($pseudo){
    $linkpdo=ConnexionBDD();
    $req = $linkpdo->prepare("SELECT pseudo FROM users where pseudo=:pseudo");
    $req->execute(array(":pseudo"=>$pseudo));
    if($req->rowCount() > 0){
        return TRUE;
    } else {
        return FALSE;
    }
}
//---------------------------------------------//
/// hash le mdp                        /////////
//--------------------------------------------//
function Hashmdp($mdp){
    return password_hash($mdp,PASSWORD_DEFAULT,["cost"=>12]);
}
//---------------------------------------------//
/// Insérer un user dans la bdd        /////////
//--------------------------------------------//
function insertUser($user,$mdp,$role){
    $linkpdo=ConnexionBDD();
    if (ifUser($user)==TRUE)
    {
        return FALSE;
    } else {
    $mdp=Hashmdp($mdp);
    $req = $linkpdo->prepare("INSERT INTO users(pseudo,mdp,role) VALUES (:pseudo,:mdp,:role)");
    if($req->execute(array(":pseudo"=>$user,":mdp"=>$mdp,":role"=>$role))){
        return TRUE;
    } else {
        return FALSE;
    }
    }
}
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
function getRoleToken($jwt){
    $tokenParts = explode('.', $jwt);
	$payload = base64_decode($tokenParts[1]);
	$role=$payload["role"];
    return $role;
}
?>