$folder = "../images/amc_attachements/";

echo "Exists: " . (is_dir($folder) ? "Yes" : "No") . "<br>";
echo "Writable: " . (is_writable($folder) ? "Yes" : "No") . "<br>";