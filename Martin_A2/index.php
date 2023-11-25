<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Martin A2</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <h1>Quiz App</h1>

    <div id="quizSelection">
    <p>Select a quiz and press start to begin:</p>

    <form action='buildQuiz.php' method='POST'>
    <select name="quizOption">
        <option value="WorldGeography.json">World Geography</option>
        <option value="NumberSystems.json">Number Systems</option>
        <option value="MusicQuiz.json">Music Quiz (Short)</option>
        <option value="MusicQuizLong.json">Music Quiz (Long)</option>
    </select>

    <button type="submit">Start</button>
    </form>
    </div>

    <div class="footer">
    <div>Jonah Martin</div>
    <div>Quiz App Enhanced</div>
    <div>September 29th, 2023</div>
    </div>

</body>
</html>