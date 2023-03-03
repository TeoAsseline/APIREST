<?php
require_once("functionSERVER.php");
//-------------------------------------------------------//
//////////////////        FUNCTION       //////////////////
//-------------------------------------------------------//
function TEST($id=null){
    $linkpdo=ConnexionBDD();
    if(is_null($id)){
        $req = $linkpdo->prepare("SELECT * FROM chuckn_facts");
        $req->execute();    
    } else {
        $req = $linkpdo->prepare("SELECT * FROM chuckn_facts where id=:id");
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