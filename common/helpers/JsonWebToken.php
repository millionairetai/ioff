<?php
namespace common\helpers;

use Firebase\JWT\JWT;
/**
 * create and parse json webtoken for authentication
 */
class JsonWebToken {
  
  const KEY = "centeroffice";
  
  public static function createToken($data){    
//    $tokenId    = base64_encode(mcrypt_create_iv(32));
    $issuedAt   = time();
    $notBefore  = $issuedAt;
    $expire     = $notBefore + 5*60*60;            // token will expire after 5h
    $serverName = 'centeroffice.dev'; // Retrieve the server name from config file
    
    $jwtInfo = array(
      'iat'  => $issuedAt,         // Issued at: time when the token was generated
//      'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
      'iss'  => $serverName,       // Issuer
      'nbf'  => $notBefore,        // Not before
      'exp'  => $expire,           // Expire
      'data' => $data
    );
    
    $token = JWT::encode($jwtInfo, self::KEY);   
    return $token;   
  }
  /**
   * Parse data from jsob webtoken
   * 
   * @param string $token
   * @return array
   */
  public static function getData($token){    
    try {
      $jwt = JWT::decode($token, self::KEY, array('HS256'));    
      return  $jwt->data;
    } catch (\Firebase\JWT\ExpiredException $e) {
      return false;
    } catch(\Firebase\JWT\BeforeValidException $e){
      return 'Caught exception: '.  $e->getMessage();
    } 
  }
}
