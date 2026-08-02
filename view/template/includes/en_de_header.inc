<?PHP

class URLEncription
{
    public $iv_size,$key;
    
    function __construct()
    {
        
        
        $this->key = pack('H*', "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3");
        
    }
    

    public  function URLEncode($plaintext)
    {
          
    
            $this->iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $iv = mcrypt_create_iv($this->iv_size, MCRYPT_RAND);
            $ciphertext = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->key, $plaintext, MCRYPT_MODE_CBC, $iv);
            $ciphertext = $iv . $ciphertext;
            //$ciphertext_base64 = base64_encode($ciphertext);

            return  $this->base64url_encode($ciphertext);
           

    }
    public  function URLDecode($dcode_string)
    {
          
            $this->iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            //$ciphertext_dec = base64_decode($dcode_string);
            $ciphertext_dec = $this->base64url_decode($dcode_string);
            $iv_dec = substr($ciphertext_dec, 0, $this->iv_size);
            $ciphertext_dec = substr($ciphertext_dec, $this->iv_size);
            $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
            
            //return $plaintext_dec;
            parse_str($plaintext_dec, $parsed);

            return $parsed;
            
    }
    public  function KEYDecode($dcode_string)
    {
          
            $this->iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            //$ciphertext_dec = base64_decode($dcode_string);
            $ciphertext_dec = $this->base64url_decode($dcode_string);
            $iv_dec = substr($ciphertext_dec, 0, $this->iv_size);
            $ciphertext_dec = substr($ciphertext_dec, $this->iv_size);
            $plaintext_dec = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key, $ciphertext_dec, MCRYPT_MODE_CBC, $iv_dec);
            
            return $plaintext_dec;
            
            
    }
    
    
    public function base64url_encode($data) {
            $data = str_replace(array('+', '/'), array('-', '_'), base64_encode($data));
            return $data;
    }
    
    public function base64url_decode($data) {
        return base64_decode(str_replace(array('-', '_'), array('+', '/'), $data));
    }
    
   
    
}


?>


