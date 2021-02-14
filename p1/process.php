<?php

session_start();

$inputString = $_POST['inputString'];

# return a string without special characters, numeric characters, and spaces
function removeNonAlphabetic($aWord)
{
    return str_replace(array("~", "`", "!", "@", "#", "$", "%", "^",
    "&", "*", "(", ")", "-", "_", "+", "=", "[", "{", "]", "}",
    "\\", ";", ":", "'", "\"", ",", "<", ".", ">", "/", "?",
    "1", "2", "3", "4", "5", "6", "7", "8", "9", "0", " "), '', $aWord);
}

# check if a string is palindrome; Case insensitive. Non-alphabetic characters are ignored
function isPalindrome($aWord)
{
    $aWord_NonAlphabetic = removeNonAlphabetic($aWord);

    return strtolower($aWord_NonAlphabetic) == strtolower(strrev($aWord_NonAlphabetic));
}

function countVowel($phrase)
{
    return substr_count($phrase, 'a')
    + substr_count($phrase, 'e')
    + substr_count($phrase, 'i')
    + substr_count($phrase, 'o')
    + substr_count($phrase, 'u')
    + substr_count($phrase, 'A')
    + substr_count($phrase, 'E')
    + substr_count($phrase, 'I')
    + substr_count($phrase, 'O')
    + substr_count($phrase, 'U');
}

function shiftLetter($phrase)
{
    $phrase_array = str_split($phrase);
    $new_phrase = [];
    foreach ($phrase_array as $value) {
        $letter_number = ord($value);
        
        # A = 65, Z = 90
        if ($letter_number >= 65 and $letter_number <= 90) {
            $letter_number = $letter_number + 1;
            # for the Z case, change it to A
            if ($letter_number == 91) {
                $letter_number = 65;
            }
        }

        # a = 97, z = 122
        if ($letter_number >= 97 and $letter_number <= 122) {
            $letter_number = $letter_number + 1;
            # for the a case, change it to a
            if ($letter_number == 123) {
                $letter_number = 97;
            }
        }
        
        $value = chr($letter_number);
        
        # append to result
        $new_phrase[] = $value;
    }
    return implode($new_phrase);
}

$isPalindromeStr = isPalindrome($inputString) ? "Yes" : "No";

if (str_replace(' ', '', $inputString) == "") {
    # if input string contains only spaces, do nothing
} else {
    $_SESSION['results'] = [
    'inputString' => $inputString,
    'isPalindrome' => $isPalindromeStr,
    'countVowel' => countVowel($inputString),
    'shiftLetter' => shiftLetter($inputString)
];
}

# redirect back to index page
header('Location: index.php');