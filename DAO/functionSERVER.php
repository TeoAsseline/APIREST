<?php
require_once("BDD.php");
//-------------------------------------------------------//
//////////////////        FUNCTION       //////////////////
//-------------------------------------------------------//
function TEST($id=null){
    $linkpdo=ConnexionBDD();
    if(is_null($id)){
        $req = $linkpdo->prepare("SELECT * FROM articles");
        $req->execute();    
    } else {
        $req = $linkpdo->prepare("SELECT * FROM articles where id_art=:id");
        $req->execute(array(':id' => $id));    
    }
    if($req->rowCount() > 0){
        $data = $req->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    } else {
        return "ERROR";
    }
}
//-------------------------------------------------------//
//////////////////        FUNCTION       //////////////////
//-------------------------------------------------------//
?>