<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Martin A2</title>
    <link rel="stylesheet" href="main.css">
</head>

<body>
    <div class="error">
        <div class="errorSymbol" id="leftError">⚠️</div>
        <div id="errorText">ERROR - this is the error page. All qusetions have not been answered!</div>
        <div class="errorSymbol" id="rightError">⚠️</div>
    </div>

    <form action="showQuestion.php" method="POST" id="errorButton">
        <!-- <input type="hidden" name="resetCounter" value="0"> -->
        <button type="submit" name="errorPage">Go Back to Quiz</button>
    </form>
</body>

</html>