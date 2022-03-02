<?php
require "dbConnection.php";

/**
 * Ajoute une nouvelle post avec ses paramètres
 * @param mixed $commentaire Commentaire du post
 * @param mixed $creationDate  La date de création du post
 * @return bool true si réussi
 */
function createPost($commentaire, $creationDate)
{
    $sql = "INSERT INTO `facebook`.`post` (`commentaire`, `creationDate`) ";
    $sql .= "VALUES (:COMMENTAIRE, :CREATIONDATE)";
    $pdo = facebookConnect();
    $ps = $pdo->prepare($sql);
    try {
        $ps->bindParam(':COMMENTAIRE', $commentaire, PDO::PARAM_STR);
        $ps->bindParam(':CREATIONDATE', $creationDate, date("Y-m-d H:i:s"));
        $ps ->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    return $pdo->lastInsertId();
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

/**
 * Ajoute une nouvelle média avec ses paramètres
 * @param mixed $typeMedia Le type du média
 * @param mixed $nomMedia Le nom du média
 * @param mixed $creationDate  La date de création du média
 * @return bool true si réussi
 */
function createMedia($typeMedia, $nomMedia, $creationDate,$idPost)
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
}     

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
