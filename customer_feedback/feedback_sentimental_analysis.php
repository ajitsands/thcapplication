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
 $texts = [
     "I love using PHP! It's an awesome language.",
     "Very Bad Service",
     "I don't knoe Your Language, But i can Learn",
     "This product is great and meets my expectations.",
 ];
//include_once "../model/db_connection/connection.php" ;
          //  $DBConn = new DBConnection();
          //  $varDBConnection = $DBConn->ConnectToMYSQL();
// $sql_text_response="SELECT response_text FROM feedback_text_responses WHERE question_id =".$ids;
           
          //   $result_text_response = mysqli_query($varDBConnection,$sql_text_response);
        	       //   while($row_text_response=mysqli_fetch_assoc($result_text_response)) {
        	       //        $texts[] = $row_text_response['response_text'];
        	      //    }
                
                
              
$sent_val="['Positive','Negative','Neutral']";
//$texts = $texts[];

    $positive = 0;
    $nagative=0;
    $neutral = 0;
// Perform sentiment analysis for each text
foreach ($texts as $index => $text) {
    $annotation = $language->analyzeSentiment($text);
    $score = $annotation->sentiment()['score'];
    $magnitude = $annotation->sentiment()['magnitude'];

  
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
    //$xy_val='[1,2,2]';
     $xy_val='[0,0,0]';
//$x_val="[".$positive.",".$nagative.",".$neutral."]";
   
}
?>

 //echo "[".$positive.",".$nagative.",".$neutral."]";
