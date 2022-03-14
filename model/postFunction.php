<?php
require "dbConnection.php";

function createMediaAndPost($typeMedia, $nomMedia, $creationDate, $commentaire, $alreadyLoop)
{
    static $ps = null;
    static $LastidPost = null; 
    $answer = false;
    $idPost = $LastidPost;
    try {
        //beginTransaction
        facebookConnect()->beginTransaction();
        if ($alreadyLoop == 0) {
            //creation Post
            $sql = "INSERT INTO `facebook`.`post` (`commentaire`, `creationDate`) ";
            $sql .= "VALUES (:COMMENTAIRE, :CREATIONDATE)";
            $pdo = facebookConnect();
            $ps = $pdo->prepare($sql);
            $ps->bindParam(':COMMENTAIRE', $commentaire, PDO::PARAM_STR);
            $ps->bindParam(':CREATIONDATE', $creationDate, date("Y-m-d H:i:s"));
            $answer = $ps->execute();
            $idPost = $pdo->lastInsertId();
            $ps->close;
        }
        //Creation Media
        $sql = "INSERT INTO `facebook`.`media` (`typeMedia`, `nomMedia`, `creationDate`, `idPost`) ";
        $sql .= "VALUES (:TYPEMEDIA, :NOMMEDIA, :CREATIONDATE, :IDPOST)";
        $ps = facebookConnect()->prepare($sql);
        $ps->bindParam(':TYPEMEDIA', $typeMedia, PDO::PARAM_STR);
        $ps->bindParam(':NOMMEDIA', $nomMedia, PDO::PARAM_STR);
        $ps->bindParam(':CREATIONDATE', $creationDate, PDO::PARAM_STR);
        $ps->bindParam(':IDPOST', $idPost, PDO::PARAM_INT);
        $answer = $ps->execute();
        $LastidPost = $idPost;
        $ps->close;

        //commit
        facebookConnect()->commit();
    } catch (PDOException $e) {
        echo $e->getMessage();
        //rollBack
        facebookConnect()->rollBack();
    }
    return $answer;
}

/*
function createPostAndReturnLastId($commentaire, $creationDate)
{
    $sql = "INSERT INTO `facebook`.`post` (`commentaire`, `creationDate`) ";
    $sql .= "VALUES (:COMMENTAIRE, :CREATIONDATE)";
    $pdo = facebookConnect();
    $ps = $pdo->prepare($sql);
    try {
        $ps->bindParam(':COMMENTAIRE', $commentaire, PDO::PARAM_STR);
        $ps->bindParam(':CREATIONDATE', $creationDate, date("Y-m-d H:i:s"));
        $ps->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $pdo->lastInsertId();
}*/

function LastIdReturn()
{
    static $ps = null;
    $sql = 'SELECT idPost ';
    $sql .= ' FROM facebook.post';
    $sql .= ' ORDER BY idPost DESC LIMIT 1';
    if ($ps == null) {
        $ps = facebookConnect()->prepare($sql);
    }
    $answer = false;
    try {
        if ($ps->execute())
            $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $answer;
}

/**
 * Supprime la post avec l'id $idPost.
 * @param mixed $idPost
 * @return bool 
 */
function deletePost($idPost)
{
    static $ps = null;
    $sql = "DELETE FROM `facebook`.`post` WHERE (`idPost` = :IDPOST);";
    if ($ps == null) {
        $ps = facebookConnect()->prepare($sql);
    }
    $answer = false;
    try {
        $ps->bindParam(':IDPOST', $idPost, PDO::PARAM_INT);
        $ps->execute();
        $answer = ($ps->rowCount() > 0);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $answer;
}
/*
/**
 * Ajoute une nouvelle média avec ses paramètres
 * @param mixed $typeMedia Le type du média
 * @param mixed $nomMedia Le nom du média
 * @param mixed $creationDate  La date de création du média
 * @return bool true si réussi

function createMedia($typeMedia, $nomMedia, $creationDate, $idPost)
{
    static $ps = null;
    $sql = "INSERT INTO `facebook`.`media` (`typeMedia`, `nomMedia`, `creationDate`, `idPost`) ";
    $sql .= "VALUES (:TYPEMEDIA, :NOMMEDIA, :CREATIONDATE, :IDPOST)";
    if ($ps == null) {
        $ps = facebookConnect()->prepare($sql);
    }
    $answer = false;
    try {
        $ps->bindParam(':TYPEMEDIA', $typeMedia, PDO::PARAM_STR);
        $ps->bindParam(':NOMMEDIA', $nomMedia, PDO::PARAM_STR);
        $ps->bindParam(':CREATIONDATE', $creationDate, PDO::PARAM_STR);
        $ps->bindParam(':IDPOST', $idPost, PDO::PARAM_INT);
        $answer = $ps->execute();
    } catch (PDOException $e) {
        error_log(json_encode($e));
        echo $e->getMessage();
    }
    return $answer;
}*/

/**
 * Supprime la note avec l'id $idMedia.
 * @param mixed $idMedia
 * @return bool 
 */
function deleteMedia($idMedia)
{
    static $ps = null;
    $sql = "DELETE FROM `facebook`.`media` WHERE (`idMedia` = :IDMEDIA);";
    if ($ps == null) {
        $ps = facebookConnect()->prepare($sql);
    }
    $answer = false;
    try {
        $ps->bindParam(':IDMEDIA', $idMedia, PDO::PARAM_INT);
        $ps->execute();
        $answer = ($ps->rowCount() > 0);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $answer;
}


function countImagesMediaAssoc($idPost)
{
    static $ps = null;

    $sql = ' SELECT count(m.idMedia) as nb';
    $sql .= ' FROM facebook.media as m ';
    $sql .= ' WHERE m.idPost = :IDPOST; ';

    if ($ps == null) {
        $ps = facebookConnect()->prepare($sql);
    }
    $answer = false;
    try {
        $ps->bindParam(':IDPOST', $idPost, PDO::PARAM_INT);

        if ($ps->execute())
            $answer = $ps->fetch(PDO::FETCH_COLUMN);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    return $answer;
}

function readMediaAssoc($idPost)
{
    static $ps = null;

    $sql = 'SELECT m.idPost, m.nomMedia, m.typeMedia ,p.commentaire';
    $sql .= ' FROM facebook.media as m, facebook.post as p ';
    $sql .= ' WHERE m.idPost = p.idPost AND m.idPost = :IDPOST; ';

    if ($ps == null) {
        $ps = facebookConnect()->prepare($sql);
    }
    $answer = false;
    try {
        $ps->bindParam(':IDPOST', $idPost, PDO::PARAM_INT);

        if ($ps->execute())
            $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    return $answer;
}

function readPost()
{
    static $ps = null;
    $sql = 'SELECT *';
    $sql .= ' FROM facebook.post';

    if ($ps == null) {
        $ps = facebookConnect()->prepare($sql);
    }
    $answer = false;
    try {
        if ($ps->execute())
            $answer = $ps->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    return $answer;
}


function Carrousel()
{
    $html = "";

    for ($i = LastIdReturn()[0]["idPost"]; $i >= 1; $i--) {
        $readMediasPost = readMediaAssoc($i);

        $html .= "<div class=\"panel panel-default\">";
        $html .= "<div id=\"myCarousel$i\" class=\"carousel slide\" data-interval=\"false\" data-ride=\"carousel\">";

        // Indicators -->
        $html .= "<ol class=\"carousel-indicators\">";
        for ($g = 0; $g < countImagesMediaAssoc($i); $g++) {
            $active = ($g == 0) ? "active" : "";
            $html .= "<li data-target=\"#myCarousel$i\" data-slide-to=\"$i\" class=\"$active\"></li>";
        }
        $html .= "</ol>";

        $html .= "<div class=\"carousel-inner\">";
        //Wrapper for slides 
        for ($e = 0; $e < countImagesMediaAssoc($i); $e++) {
            $active = ($e == 0) ? "active" : "";
            $html .= "<div class=\"item $active\" align=\"center\">";

            if ($readMediasPost[$e]["typeMedia"] == "png" || $readMediasPost[$e]["typeMedia"] == "jpg" || $readMediasPost[$e]["typeMedia"] == "jpeg" || $readMediasPost[$e]["typeMedia"] == "gif" || $readMediasPost[$e]["typeMedia"] == "jpg"){
                $html .= "<img src=\"uploaded/" . $readMediasPost[$e]["nomMedia"] . "\" alt=\"" . $readMediasPost[$e]["nomMedia"] . "\">";
                $html .= "</div>";
            }

            if ($readMediasPost[$e]["typeMedia"] == "mp4" || $readMediasPost[$e]["typeMedia"] == "m4v") {
                $html .= "\n <video width=\"100%\" height=\"100%\" controls autoplay loop muted >";
                $html .= "\n <source src=\"uploaded/" . $readMediasPost[$e]["nomMedia"] . "\" type=\"video/mp4\">";
                $html .= "\n </video>";
                $html .= "\n </div>";
            }             

            if ($readMediasPost[$e]["typeMedia"] == "mp3" || $readMediasPost[$e]["typeMedia"] == "wav" || $readMediasPost[$e]["typeMedia"] == "ogg") {
                $html .= "\n <audio controls>";
                $html .= "\n <source src=\"uploaded/" . $readMediasPost[$e]["nomMedia"] . "\">";
                $html .= "\n </audio>";
                $html .= "\n </div>";
            }
        }
        $html .= "</div>";


        // Left and right controls -->
        $html .= "<a class=\"left carousel-control\" href=\"#myCarousel$i\" data-slide=\"prev\">";
        $html .= "<span class=\"glyphicon glyphicon-chevron-left\"></span>";
        $html .= "<span class=\"sr-only\">Previous</span>";
        $html .= "</a>";
        $html .= "<a class=\"right carousel-control\" href=\"#myCarousel$i\" data-slide=\"next\">";
        $html .= "<span class=\"glyphicon glyphicon-chevron-right\"></span>";
        $html .= "<span class=\"sr-only\">Next</span>";
        $html .= "</a>";
        $html .= "</div>";

        $html .= "<div class=\"panel-body\">";
        $html .= "<p class=\"lead\">" . $readMediasPost[0]["commentaire"] . "</p>";
        $html .= "</div>";
        $html .= "</div>";
    }

    return $html;
}
