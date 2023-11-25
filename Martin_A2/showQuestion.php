<?php //functions
/**
 * checks if user clicked a radio button on the last question
 * adds index of selected radio button to userAnswers array at the index of the current question
 * 
 * @param Integer - $currentQuestionIndex - still previous question index, will be updated when checking next/previous
 */
function updateUserAnswers($currentQuestionIndex)
{
    //check if the previous question was answered, if it was, update userAnswers
    $IndexOfPreviousQuestionAnswered = "question{$currentQuestionIndex}";
    if (isset($_POST[$IndexOfPreviousQuestionAnswered])) {
        $_SESSION['userAnswers'][$currentQuestionIndex] = $_POST[$IndexOfPreviousQuestionAnswered];
    }
}
/**
 * checks if all questions have been answered. If they have, send them to results.php, otherwise send to errorPage.php
 * 
 * @param Array - $userAnswers - array of radio button indexes (array was initialized to -1)
 */
function handleDone($userAnswers)
{
    //check if all questions are answered
    $allAnswered = true;
    for ($i = 0; $i < count($userAnswers); $i++) {
        if ($userAnswers[$i] == -1) {
            $allAnswered = false;
            break;
        }
    }
    //if they are -> results.php
    if ($allAnswered) {
        header("Location: results.php");
    }
    //otherwise -> errorPage.php
    else {
        header("Location: errorPage.php");
    }
}

/**
 * builds the question by outputting question number, question text, and looping through choices to output radio buttons
 * checks userAnswers array to see if current question has been answered & applies checked attribute
 * 
 * @param Array - $theQuiz - JSON parsed associative array 
 * @param Array - $userAnswers - array of indexes from user-selected radio buttons (-1 by default)
 * @param Integer - $currentQuestionIndex - index of question we're currently on
 */
function buildQuestion($theQuiz, $userAnswers, $currentQuestionIndex)
{
    //build options

    $currentQuestion = $theQuiz['questions'][$currentQuestionIndex];
    echo "<div class='questionCard'>" . $currentQuestion['questionText'];
    for ($i = 0; $i < count($currentQuestion["choices"]); $i++) {
        //determine if radio button needs to be checked
        $checked = "";
        if ($userAnswers[$currentQuestionIndex] == $i) {
            $checked = "checked";
        }
        $currentOption = $currentQuestion['choices'][$i];
        echo "<div class='radAnswers'>
                  <input type='radio' id='{$i}'name='question{$currentQuestionIndex}' value='{$i}' $checked>
                  <label for={$i}>{$currentOption}</div>";
        // echo var_dump($userAnswers);
    }
}
/**
 * builds buttons & disables them accordingly if we're on first/last question, then outputs them
 * 
 * @param Array - $theQuiz - JSON parsed associative array 
 * @param Integer - $currentQuestionIndex - index of question we're currently on
 */
function buildButtons($theQuiz, $currentQuestionIndex)
{
    //determine whether to disable or not
    $previousDisabled = "";
    $nextDisabled = "";
    $numberOfQuestions = count($theQuiz['questions']);
    if ($currentQuestionIndex == 0) {
        $previousDisabled = "disabled";
    } else if ($currentQuestionIndex == $numberOfQuestions - 1) {
        $nextDisabled = "disabled";
    }
    //either puts string disabled or "" into html element
    $previous = "<button type='submit' name='previous' value='prev' {$previousDisabled}>Previous</button>";
    $next = "<button type='submit' name='next' value='next' {$nextDisabled}>Next</button>";
    $done = "<button type='submit' name='done' value='done'>Done</button>";

    //output buttons
    echo $previous . $next . $done . "</div>";
}

function checkOutOfBounds($currentQuestionIndex, $theQuiz)
{
    if ($currentQuestionIndex <= 0 || $currentQuestionIndex >= count($theQuiz['questions']))
        return $currentQuestionIndex;
}
?>

<!-- html page -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Martin A2</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <?php
    session_start();
    $theQuiz = $_SESSION['theQuiz'];
    //currentQuestionIndex at this moment is previous question's index -- will be updated as we go
    $currentQuestionIndex = $_SESSION['currentQuestionNumber'];

    updateUserAnswers($currentQuestionIndex);

    //array of -1 -> changes when question is answered to index of radio button chosen
    $userAnswers = $_SESSION['userAnswers'];

    //determine how we got to page
    if (isset($_POST['done'])) {
        handleDone($userAnswers);
    } else if (isset($_POST['previous'])) {

        $currentQuestionIndex--;

        //check if out of bounds
        if ($currentQuestionIndex <= 0) {
            $currentQuestionIndex = 0;
        }


        //set session variable to new index value
        $_SESSION['currentQuestionNumber'] = $currentQuestionIndex;
    } else if (isset($_POST['next'])) {
        $numQuestions = count($theQuiz['questions']);
        $currentQuestionIndex++;

        //check if out of bounds
        if ($currentQuestionIndex >= $numQuestions) {
            $currentQuestionIndex = $numQuestions - 1;
        }

        //set session variable to new index value
        $_SESSION['currentQuestionNumber'] = $currentQuestionIndex;
    }
    //if none trigger, then we start from question 1

    //title
    echo "<h1>{$theQuiz['title']} 📝</h1>";

    //display question Number
    $questionNumberToDisplay = $currentQuestionIndex + 1;
    echo "<div class='questionNum'>Question {$questionNumberToDisplay}</div>";
    ?>

    <!-- build form -->
    <form action="showQuestion.php" method='POST'>
        <?php
        buildQuestion($theQuiz, $userAnswers, $currentQuestionIndex);
        buildButtons($theQuiz, $currentQuestionIndex);
        ?>
    </form>

    <!-- footer -->
    <div class="footer">
        <div>Jonah Martin</div>
        <div>Quiz App Enhanced</div>
        <div>September 29th, 2023</div>
    </div>
</body>

</html>