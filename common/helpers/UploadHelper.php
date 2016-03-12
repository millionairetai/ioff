<?php

namespace common\helpers;

use yii\imagine\Image;

class UploadHelper 
{
    
  public static function uploadImage($uploadFile, $folderName) 
  {
    $fileExt = explode('/', $uploadFile['type']);
    
    if ($fileExt[0] === 'image' || $fileExt[0] === 'application') {
      if ($uploadFile['size'] < 3000000) {
        $fileName = uniqid() . '-' . self::cleanFileName($uploadFile['name']);       
        if (move_uploaded_file($uploadFile['tmp_name'], UPLOAD_PATH.$folderName.'/' . $fileName)) {
          return array(
              'isSuccess' => true,
              'data' => $fileName,
              'fileName' => $uploadFile['name'],
              'fileLink' =>  '/uploads/'.$folderName.'/' . $fileName,
              'fileType' => 3
          );
        }
      } else {
        return array(
            'isSuccess' => false,
            'data' => 'Please upload a file size < 3MB'
        );
      }
    } else {
      return array(
          'isSuccess' => false,
          'data' => 'Please upload a valid image file'
      );
    }
  }
  public static function cleanFileName($string) 
  {
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9.\-]/', '', $string); // Removes special chars.
  }
  
  public static function removeFolder($path)
  {
    if (is_dir($path)) {
      $files = array_diff(scandir($path), array('.','..')); 
      foreach ($files as $file) { 
        $filePath = $path.$file;
        if(file_exists($filePath)){
          unlink($filePath); 
        }
      } 
      return rmdir($path);
    }
  }
  
  public static function uploadImageBase64File($base64File, $fileName,$folderName){
    if(strpos($base64File, 'image') !== false){
      $base64File = substr($base64File, strpos($base64File, ",") + 1);
      $decodedFile = base64_decode($base64File);
      if(strlen($decodedFile)  < 3000000 ){
        $imgName = uniqid() . '-' . UploadHelper::cleanFileName($fileName);
        file_put_contents(UPLOAD_PATH . $folderName . '/' . $imgName, $decodedFile); //create an image
        return array(
              'isSuccess' => true,
              'data' => $imgName              
          );
      }else {
        return array(
            'isSuccess' => false,
            'data' => 'Please upload a file size < 3MB'
        );
      }
      
    }else {
      return array(
          'isSuccess' => false,
          'data' => 'Please upload a valid image file'
      );
    }
    
  }      
}
