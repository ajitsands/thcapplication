<?php
require 'vendor/autoload.php';

use Google\Cloud\Language\LanguageClient;

// Set the path to your JSON key file
$keyFilePath = 'googlekeyjson/voicetophp-404707-7bcd0ee05d95.json';

// Initialize LanguageClient
$language = new LanguageClient([
    'keyFilePath' => $keyFilePath,
]);

// Array of sample texts for sentiment analysis
// $texts = [
//     "I love using PHP! It's an awesome language.",
//     "Very Bad Service",
//     "I don't knoe Your Language, But i can Learn",
//     "This product is great and meets my expectations.",
// ];
$texts = $_POST['arrayval'];

    $positive = 0;
    $nagative=0;
    $neutral = 0;
// Perform sentiment analysis for each text
foreach ($texts as $index => $text) {
    $annotation = $language->analyzeSentiment($text);
    $score = $annotation->sentiment()['score'];
    $magnitude = $annotation->sentiment()['magnitude'];

    // echo "Text $index: $text<br>";
    // echo "Sentiment Score: $score<br>";
    // echo "Sentiment Magnitude: $magnitude<br>";
  
    // Interpret sentiment
    if ($score < 0.0) {
        //echo "Sentiment: Negative\n";
        $nagative +=1;
    } elseif ($score > 0.0) {
        //echo "Sentiment: Positive\n";
        $positive += 1;
    } else {
        //echo "Sentiment: Neutral\n";
        $neutral += 1;
    }

   
}
 echo "( Positive : ".$positive.", Negative: ".$nagative.", Neutral : ".$neutral." )";
