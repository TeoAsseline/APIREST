<?php
$id=$_GET['id'];
if(isset($_SESSION['token'])){
    $token=$_SESSION['token'];
} else {
    $token="Aucun Token";
}
DELETEArticle($id,$token);
?>
<script>window.location.href = "../index.php";</script>