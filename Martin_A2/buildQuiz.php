<?php
$fileName = $_POST['quizOption'];

echo ($fileName);

//create json 'associative array' (access using ['fieldName'] vs [index]) vs object which you access using: quiz->fieldName
$file = fopen($fileName, "r") or die("cannot find quiz");
$fileContent = fread($file, filesize($fileName));
fclose($file);
//true makes it an associative array
$theQuiz = json_decode($fileContent, true);

//save values in session variable
//save quiz, initialized question number, initialized user answer array
session_start();
$_SESSION['theQuiz'] = $theQuiz;
$_SESSION['currentQuestionNumber'] = 0;

$userAnswers = array();
for ($i = 0; $i < count($theQuiz['questions']); $i++) {
    array_push($userAnswers, -1);
}

$_SESSION['userAnswers'] = $userAnswers;

//go to next page w/ these values now saved
header("Location: showQuestion.php");
