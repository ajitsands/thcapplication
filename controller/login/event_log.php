<?php
class EvenLog  
{
	public $jsonData,$sCurrDate,$sDirPath,$filePath,$lines;
	public function __construct()
	{
		//$this->jsonData = file_get_contents('php://input');
		
			$formData = array();

			// Iterate over $_POST to capture non-file fields
			foreach ($_POST as $key => $value) {
				$formData[$key] = $value;
			}
			foreach ($_FILES as $key => $file) {
				$formData[$key] = array(
					'FILENAME' => $file['name'], 
					// Add more file-related information as needed
				);
			}
			$this->jsonData = json_encode($formData);
			echo $this->jsonData;
		
		$this->sCurrDate = date("Y-m"); //Current Date

    	$this->sDirPath = "logs/".$this->sCurrDate."/"; //Specified Pathname
		
		$data = json_decode($this->jsonData, true);
		$this->filePath = $this->sDirPath.date("Y-m-d").'.json';
    
    	if (!file_exists ($this->sDirPath))
       	{
    	    	mkdir($this->sDirPath,0777,true); 
    	} 

		if (file_exists($this->filePath)) {
			$this->writeToFileAsJSON('Exist',$this->filePath,$this->jsonData);
		}
		else
		{
			$this->writeToFileAsJSON('NewFile',$this->filePath,$this->jsonData);
		}
	}
	
	function writeToFileAsJSON($fileStatus,$filePath,$jsonData)
	{
		

		if($fileStatus=='Exist')
		{
			$this->lines = file($filePath);
			if (count($this->lines) > 0) {
			// Remove the last line
			array_pop($this->lines);

			// Write the modified content back to the file
			file_put_contents($filePath, implode('', $this->lines));

			}
			file_put_contents($filePath, ','.$jsonData . PHP_EOL, FILE_APPEND);
			file_put_contents($filePath, ']' . PHP_EOL, FILE_APPEND);
		}
		else{
			file_put_contents($filePath, '[' . PHP_EOL, FILE_APPEND);
			file_put_contents($filePath, $jsonData . PHP_EOL, FILE_APPEND);
			file_put_contents($filePath, ']' . PHP_EOL, FILE_APPEND);
		}
		// Write the JSON data to the file in append mode


		// Optionally, you can echo a success message or handle the response in some way
		header('Content-Type: application/json');
		echo json_encode(['status' => 'success']);
	}
	
} // Close of Class EvenLog

$obj = new EvenLog();



?>