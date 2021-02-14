<!doctype html>
<html lang='en'>

<head>
    <title>e15 Project 1</title>
    <!-- bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
        crossorigin="anonymous">
    <meta charset='utf-8'>
</head>

<body>

    <div class="container text-center mt-5">
        <h1>E15 Project 1 - String Processor</h1>

        <form method='POST' action='process.php'>
            <label for='inputString' class="fs-4">Enter a string</label>
            <input type='text' name='inputString' id='inputString' class="d-block mx-auto rounded-pill">
            <button type='submit' class="mt-2">Process</button>
        </form>

        <!-- Result area -->
        <?php if (isset($inputString)): ?>
        <div class="border border-secondary text-center mx-5 mt-2 pt-2">
            <h3>Results</h3>
            <h4>String</h4>
            <p><?php echo $inputString ?>
            </p>
            <h4>Is palindrome?</h4>
            <p><?php echo $isPalindrome ?>
            </p>
            <h4>Vowel count:</h4>
            <p><?php echo $countVowel ?>
            </p>
            <h4>Letter shift:</h4>
            <p><?php echo $shiftLetter ?>
            </p>
        </div>
        <?php endif ?>
    </div>
</body>

</html>