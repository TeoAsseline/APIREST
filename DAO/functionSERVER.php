<?php
require_once("BDD.php");
require_once("functionUser.php");
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
//-------------------------------------------------------//
///////////        FUNCTION TEMPLATE     //////////////////
//-------------------------------------------------------//
function ReqSelect($sql,$id=null){
    $linkpdo=ConnexionBDD();
    $req = $linkpdo->prepare($sql);
    $req->execute();    
    if($req->rowCount() > 0){
        $data = $req->fetchAll();
        return $data;
    } else {
        return 0;
    }
}
function ReqUpdateDeleteInsert($sql,$id=null){
    $linkpdo=ConnexionBDD();
    if(is_null($id)){
        return 0;    
    } else {
        $req = $linkpdo->prepare($sql);
        if($req->execute()){
            return 1;
        }else {
            return 0;
        }
    }
}
//-------------------------------------------------------//
//////////////////  ROLE non Authentifié       ////////////
//-------------------------------------------------------//
//-------------------------------------------------------------------//
//////////////////  Récupérer Liste article ou 1 Article      /////////
//-------------------------------------------------------------------//
function getArticleNAuth($id=null){
    $sql="SELECT * FROM articles";
    if(is_null($id)){
        return ReqSelect($sql);    
    } else {
        return ReqSelect($sql." where id_art=$id");   
    }
}
//-------------------------------------------------------//
//////////////////  ROLE Administrateur        ////////////
//-------------------------------------------------------//
//-----------------------------------------------------------------------------//
////////  Récupérer Liste Article ou 1 Article (Toutes Informations) ////////////
//-----------------------------------------------------------------------------//
function getArticleAdmin($id=null){
    $result = getArticlePublisher($id);
    foreach($result as $art){
        $art['ListLike']=getListLikeDislike(1,$art["id_art"]);
        $art['ListDislike']=getListLikeDislike(0,$art["id_art"]);
    }
    return $result;
}
//-----------------------------------------------------------------------------//
////////  Récupérer Nb Like/Dislike Article (0=dislike, 1=like)      ////////////
//-----------------------------------------------------------------------------//
function getLikeDislike($like, $id=null){
    $sql="SELECT COUNT(*) as nb FROM avis WHERE ressentiment=$like";
    if(is_null($id)){
        return ReqSelect($sql)[0]["nb"]; 
    } else {
        return ReqSelect($sql." AND id_article=$id")[0]["nb"];
    }
}
//------------------------------------------------------------//
////////  Récupérer Liste Like/Dislike Article      ////////////
//------------------------------------------------------------//
function getListLikeDislike($like,$id=null){
    $sql="SELECT id_auteur FROM avis WHERE ressentiment=$like";
    if(is_null($id)){
        return ReqSelect($sql); 
    } else {
        return ReqSelect($sql." AND id_article=$id");
    }
}
//--------------------------------------//
////////  Delete Article      ////////////
//--------------------------------------//
function deleteArticleAdmin($id){
    $sql="DELETE FROM articles WHERE id_art=$id";
    return ReqUpdateDeleteInsert($sql,$id);
}
//-------------------------------------------------------//
//////////////////  ROLE Publisher             ////////////
//-------------------------------------------------------//
//-------------------------------------------------------//
//////////////////  Ajout Article              ////////////
//-------------------------------------------------------//
function insertArticlePublisher($pseudo, $contenu, $titre){
    $pseudo = getIdByPseudo($pseudo);
    date_default_timezone_set('Europe/Paris');
    $horaire = date("Y-m-d H:i:s");
    $sql ="INSERT INTO articles (contenu, nom_publication, date_publication, auteur) VALUES('$contenu','$titre','$horaire',$pseudo)";
    return ReqUpdateDeleteInsert($sql,$pseudo);
}
//--------------------------------------------------------------//
//////////////////  Récupérer mes Articles            ////////////
//--------------------------------------------------------------//
function getMyArticlePublisher($pseudo){
    $id_pseudo=getIdByPseudo($pseudo);
    $sql="SELECT id_art,date_publication,contenu FROM articles WHERE auteur=$id_pseudo";
    $result= ReqSelect($sql);    
    foreach($result as $art){
        $art['nbLike']=getLikeDislike(1,$art["id_art"]);
        $art['nbDislike']=getLikeDislike(0,$art["id_art"]);
    }
    return $result;
}
//-------------------------------------------------------------------------------//
//////////////////  Vérifier si article appartient au pseudo           ////////////
//-------------------------------------------------------------------------------//
function ifArticleIsAuteur($id_pseudo,$id_art){
    $sql="SELECT id_art FROM articles WHERE auteur=$id_pseudo and id_art=$id_art";
    $result = ReqSelect($sql);
    if($result == 0){
        return 0;
    } else {
        return 1;
    }
}
//-------------------------------------------------------------------------------------------------------//
////////////////// Récupérer Liste Article ou 1 Article des publishers (Sans liste des likers) ////////////
//-------------------------------------------------------------------------------------------------------//
function getArticlePublisher($id=null){
    $result = getArticleNAuth($id);   
    foreach($result as $art){
        $art['nbLike']=getLikeDislike(1,$art["id_art"]);
        $art['nbDislike']=getLikeDislike(0,$art["id_art"]);
    }
    return $result;
}
//-------------------------------------------------------//
//////////////////  Modification mon Article   ////////////
//-------------------------------------------------------//
function updateArticlePublisher($id,$contenu,$nom,$pseudo){
    $id_pseudo=getIdByPseudo($pseudo);
    $sql="UPDATE articles SET contenu='$contenu',nom_publication='$nom' WHERE id_art=$id AND auteur=$id_pseudo";
    return ReqUpdateDeleteInsert($sql,$id);
}
//-------------------------------------------------------//
//////////////////  Delete mon Article         ////////////
//-------------------------------------------------------//
function deleteArticlePublisher($id,$pseudo){
    $id_pseudo=getIdByPseudo($pseudo);
    $sql="DELETE FROM articles WHERE id_art=$id AND auteur=$id_pseudo";
    return ReqUpdateDeleteInsert($sql,$id);
}
//-------------------------------------------------------------------------------//
//////////////////  Vérifier si un pseudo a deja like un art           ////////////
//-------------------------------------------------------------------------------//
function ifLikeOnArticle($id_pseudo,$id_art){
    $sql="SELECT * FROM avis WHERE id_auteur=$id_pseudo and id_article=$id_art";
    $result = ReqSelect($sql);
    if($result == 0){
        return 0;
    } else {
        return 1;
    }
}
//-----------------------------------------------------------------------//
//////////////////  Update or Insert Like/Dislike d'un Article  ///////////
//-----------------------------------------------------------------------//
function LikeArticlePublisher($pseudo,$id_art,$like){
    $id_pseudo=getIdByPseudo($pseudo);
    if(ifLikeOnArticle($id_pseudo,$id_art)==1){
        $sql="UPDATE avis SET ressentiment='$like' WHERE id_article=$id_art AND id_auteur=$id_pseudo";
        if(ifArticleIsAuteur($id_pseudo,$id_art)==1){
            return 0; 
        } else {
            return ReqUpdateDeleteInsert($sql,$id_pseudo);
        }
    } else {
        $sqlinsert="INSERT INTO avis(id_auteur,id_article,ressentiment) VALUES ($id_pseudo,$id_art,$like)";
        if(ifArticleIsAuteur($id_pseudo,$id_art)==1){
            return 0; 
        } else {
            return ReqUpdateDeleteInsert($sqlinsert,$id_pseudo);
        }
    }
}
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
?>