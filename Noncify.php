<?php
/**
  * @name  Noncify
  * @author  Mark Eriksson (https://markwrites.codes)
  * @link  https://github.com/Markshall/Noncify
  * @desc  Generate and verify previously generated nonces for use in web forms
  */
class Noncify {
  
  /**
    * @param $key  the salt being used by the website
    * @param $timeout  the amount of time (in minutes) after which the nonce will expire
    * @return string  the generated nonce
    */
  public static function generate($key, $timeout=5) {
    if (!is_string($key) || !is_numeric($timeout)) {
      throw new InvalidArgumentException('Invalid arguments supplied');
    }
    
    $salt = self::randString($timeout);
    $timestamp = time() + ($timeout * 60);

    $nonce = substr(sha1($key), 0, 15) . '.' . $timestamp . '.' . $salt . '.' . sha1("{$salt}.{$timestamp}.{$key}");
    return $nonce;
  }
  
  
  /**
    * @param $nonce  the full nonce string created by this class
    * @param $key  the salt passed into generate() used by the website
    * @return bool  if the nonce is valid and not expired
    */
  public static function verify($nonce, $key) {
    $nonceBits = explode('.', $nonce);
    
    return substr(sha1($key), 0, 15) === $nonceBits[0] && time() < $nonceBits[1] && sha1("{$nonceBits[2]}.{$nonceBits[1]}.{$key}") === $nonceBits[3];
  }
  
  
  /**
    * @param $length  the amount of characters to be used in the random string
    *                 not user defined. value is based on the $timeout param in generate()
    *                 we divide the $timeout param by 4 and if its value is less than 8 then
    *                 make the random string 8 chars long
    * @return string  the randomly generated string
    */
  private static function randString($length) {
    $chars   = '1QAZ2WSX3EDC4RFV5TGB6YHN7UJM8IK9OL0Pqazwsxedcrfvtgbyhnujmikolp';
    $string  = '';
    $length /= 4;
    
    if (strval($length) < 8)
      $length = 8;
    
    for ($i=0; $i<round($length); $i++)
      $string .= $chars[mt_rand(0, strlen($chars)-1)];
    
    return $string;
  }
}
