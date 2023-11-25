<?php
//functions
/**
 * rebuilds the quiz questions (question num, question text)
 * calls buildOptions to build user options
 * 
 * @param Array - $theQuiz - JSON parsed associative array 
 * @param Array - $userAnswers - array of user answers that was updated from showQuestion.php
 * @param Integer - $numCorrect - PASSED BY REFERENCE: keeps track of the number of correct answers
 */
function buildQuestions($theQuiz, $userAnswers, &$numCorrect)
{
    //output question numbers & question text
    for ($i = 0; $i < count($theQuiz['questions']); $i++) {
        $displayNumber = $i + 1;
        echo "<div class='question'>
        <p>Question {$displayNumber}: {$theQuiz['questions'][$i]['questionText']}</p>";

        //send question we're on and answer at that index into buildOptions
        $currentQuestion = $theQuiz['questions'][$i];
        $userAnswersElement = $userAnswers[$i];
        //output radio buttons with correct/incorrect highlight
        buildOptions($userAnswersElement, $currentQuestion, $numCorrect);
        echo "</div>";
    }
}
/**
 * builds the radio buttons. selects the answer the user chose (checks if answer was correct
 * using checkCorrect() function then applies X or Checkmark accordingly)
 * 
 * @param Integer - $userAnswersElement - index of user answer for this question
 * @param Array - $currentQuestion - gives us access to array of values associated with current question
 * @param Integer - $numCorrect - PASS BY REFERENCE: sends to checkCorrect to update original numCorrect variable to display score
 */
function buildOptions($userAnswersElement, $currentQuestion, &$numCorrect)
{
    for ($i = 0; $i < count($currentQuestion['choices']); $i++) {
        $checked = "";
        $currentOption = $currentQuestion['choices'][$i];
        $correctIncorrectClass = "";
        $checkOrEx = "";

        //check if radio button was checked -> apply checked attribute
        //check if answer was correct -> reassign correct/incorrect to variable
        if ($userAnswersElement == $i) {
            $checked = "checked";

            if (checkCorrect($currentQuestion, $userAnswersElement, $numCorrect)) {
                $correctIncorrectClass = "correct";
                $checkOrEx = "✅";
            } else {
                $correctIncorrectClass = "incorrect";
                $checkOrEx = "❌";
            }
        }

        //always green highlight correct answer
        if ($currentQuestion['answer'] == $i) {
            $correctIncorrectClass = "correct";
            $checkOrEx = "✅";
        }
        //output
        $name = $currentQuestion['questionText'];
        echo "<div class='radAnswers {$correctIncorrectClass}'>
          <input type='radio' $checked name='question{$name}' disabled>
            {$currentOption}{$checkOrEx}</div>";
    }
}
/**
 * builds the radio buttons. selects the answer the user chose (checks if answer was correct
 * using checkCorrect() function then applies X or Checkmark accordingly)
 * 
 * @param Array - $currentQuestion - gives us access to array of values associated with current question
 * @param Integer - $userAnswersElement - index of user answer for this question
 * @param Integer - $numCorrect - PASS BY REFERENCE: updates original numCorrect variable to display score
 */
function checkCorrect($currentQuestion, $userAnswersElement, &$numCorrect)
{
    $isCorrect = false;
    if ($currentQuestion['answer'] == $userAnswersElement) {
        $isCorrect = true;
        $numCorrect++;
    }
    return $isCorrect;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Martin A2</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <?php //build quiz results
    session_start();
    //original quiz, chosen on index.php
    $theQuiz = $_SESSION['theQuiz'];
    //user answers up to date w/ quiz submission
    $userAnswers = $_SESSION['userAnswers'];
    $numCorrect = 0;
    $quizSize = count($theQuiz['questions']);
    //title
    echo "<h1>{$theQuiz['title']} - Results📝</h1>";
    //build quiz results
    buildQuestions($theQuiz, $userAnswers, $numCorrect);
    //score
    echo "<div class='score'>Score: {$numCorrect} / {$quizSize}</div>";

    ?>

    <!-- take another quiz button-->
    <form action="index.php" id="resultsButton">
        <button type="submit">Take Another Quiz!</button>
    </form>

    <!-- footer -->
    <div class="footer">
        <div>Jonah Martin</div>
        <div>Quiz App Enhanced</div>
        <div>September 29th, 2023</div>
    </div>
</body>

</html>