<?php

// require "Util.php";


class Database {

    
    public static function DateExists($date) {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=unihack2025", "andrew", "andrew1105");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $stmt = $conn->prepare("SELECT COUNT(*) FROM entries WHERE date = :date");
            $stmt->bindValue(':date', $date, PDO::PARAM_STR);
            $stmt->execute();
    
            $count = $stmt->fetchColumn();
    
            return $count > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

    public static function UpdateEmotion($date, $label, $score){

        try {
            $conn = new PDO("mysql:host=localhost;dbname=unihack2025", "andrew", "andrew1105");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $stmt = $conn->prepare("UPDATE `entries` SET `label` = :label, `score` = :score WHERE `date` = :date");

            $stmt->bindValue(':label', $label, PDO::PARAM_STR);
            $stmt->bindValue(':score', $score, PDO::PARAM_STR);
            $stmt->bindValue(':date', $date, PDO::PARAM_STR);
            $stmt->execute();
    
            return $count > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    public static function AddEntry($date, $title, $text){

        try{

            $conn = new PDO("mysql:host=localhost;dbname=unihack2025", "andrew", "andrew1105");
            $stmt = $conn->prepare("INSERT INTO `entries`(`date`, `title`, `text`, `label`, `score`) VALUES (:date, :title, :text, 'pending', 'pending')");
            
            $stmt->bindValue(':date', $date, PDO::PARAM_STR);
            $stmt->bindValue(':title', $title, PDO::PARAM_STR);
            $stmt->bindValue(':text', $text, PDO::PARAM_STR);

            $stmt->execute();
            
        } catch (PDOException $e) {
            return false;
        }        

    }


    public static function GetEntry($date) {
        try {

            $conn = new PDO("mysql:host=localhost;dbname=unihack2025", "andrew", "andrew1105");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $stmt = $conn->prepare("SELECT * FROM entries WHERE date = :date");
            $stmt->bindValue(':date', $date, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return false;
        }
    }




}