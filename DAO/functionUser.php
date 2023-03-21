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
    $hash=getMdp($pseudo);
    if (password_verify($mdp,$hash)==true) {
        $req = $linkpdo->prepare("SELECT * FROM users where pseudo=:pseudo and mdp=:mdp");
        $req->execute(array(":pseudo"=>$pseudo,":mdp"=>$hash));
        if($req->rowCount() > 0){
            return 1;
        } else {
            return 0;
        }
    } else {
        return 0;
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
        return 1;
    } else {
        return 0;
    }
}
//---------------------------------------------//
/// Insérer un user dans la bdd        /////////
//--------------------------------------------//
function insertUser($user,$mdp,$role){
    $linkpdo=ConnexionBDD();
    if (ifUser($user)==1){
        return 0;
    } else {
        $hash=password_hash($mdp,PASSWORD_DEFAULT,["cost"=>12]);
        $req = $linkpdo->prepare("INSERT INTO users(pseudo,mdp,role) VALUES (:pseudo,:mdp,:role)");
        if($req->execute(array(":pseudo"=>$user,":mdp"=>$hash,":role"=>$role))){
            return 1;
        } else {
            return 0;
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