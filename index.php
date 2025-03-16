<?php
$begin = microtime(TRUE);

require "Util.php";
require "Database.php";

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");

Util::Log("api requested, payload: " . json_encode($_POST));

if($_SERVER["REQUEST_METHOD"] === "GET"){
    echo json_encode([
        "response" => "ok",
        "response_time" => microtime(TRUE)-$begin
    ]);
}

if(isset($_POST['action'])) {

    $action = $_POST['action'];
    
    if($action === 'add_entry'){

        Util::Log("add_entry called");

        $date = $_POST['date'];

        if(!Database::DateExists($date)){

            Util::Log("Date_not_exists " . $date);

            $title = $_POST['title'];
            $text = $_POST['text'];
            
            Database::AddEntry($date, $title, $text);

            ob_start();

            echo json_encode([
                "response" => "entry_inserted",
                "response_time" => microtime(TRUE)-$begin
            ]);

            header("Content-Length: " . ob_get_length());
            header("Connection: close");
            ob_end_flush(); 
            ob_flush(); 
            flush();

            Util::Log("Executing classifier in background");

            exec("/var/www/html/venv/bin/python emotion_classifier.py '$text' 2>&1", $output);

            $result = explode("#", $output[1]);
            $label = $result[0];
            $score = $result[1];

            Database::UpdateEmotion($date, $label, $score);
            Util::Log("Updated entry " . $date . ": " . $label . ", " . $score);

        } else {

            Util::Log("Date_exists " . $date);

            echo json_encode([
                "response" => "date_already_exists",
                "response_time" => microtime(TRUE)-$begin
            ]);

        }

    }

    elseif($action === 'get_dates'){

        Util::Log("get_dates called");

        $dates = Database::GetDates();

        echo json_encode([
            "response" => "ok",
            "dates" => $dates,
            "response_time" => microtime(TRUE)-$begin
        ]);

    }

    elseif($action === 'get_entry'){

        Util::Log("get_entry called");

        $date = $_POST['date'];

        if(!Database::DateExists($date)){

            echo json_encode([
                "response" => "date_does_not_exist",
                "response_time" => microtime(TRUE)-$begin
            ]);

        } else {

            $result = Database::GetEntry($date);

            echo json_encode([
                "response" => "ok",
                "title" => $result["title"],
                "text" => $result["text"],
                "label" => $result["label"],
                "score" => $result["score"],
                "response_time" => microtime(TRUE)-$begin
            ]);

        }

    }

}