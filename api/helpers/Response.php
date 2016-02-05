<?php

namespace api\helpers;

use MongoId;
use MongoDate;

/**
 * @author Tuong Tran <tuong.tran@outlook.com>
 */
class Response {

  /**
   * format mongoobject to string, mongo date to date time
   *
   * @param mixed $data
   */
  public static function populateMongoOject(&$object) {
    $object = static::convertData($object);
  }

  /**
   * Converts an object or an array of objects into an array.
   * @param type $object
   * @param type $properties
   * @param type $recursive
   * @return \api\helpers\Arrayable
   */
  private static function convertData($object, $properties = [], $recursive = true) {
    if (is_array($object)) {
      if ($recursive) {
        foreach ($object as $key => $value) {
          if(is_array($value)){
            $len = count($value);
            //mongo id
            if($len === 1 && isset($value['$id'])){
              $object[$key] = $value['$id'];
            }elseif($len === 2 && isset($value['sec']) && isset($value['usec'])){
              //mongo date
              $object[$key] = $value['sec']*1000;//date('Y-m-d H:i:s', $value['sec']);
            }else{
              $object[$key] = static::convertData($value, $properties, true);
            }
          }elseif (is_object($value)) {
            $object[$key] = static::convertData($value, $properties, true);
          }
        }
      }

      return $object;
    } elseif (is_object($object)) {
      if($object instanceof MongoId){
        return (string)$object;
      }elseif($object instanceof MongoDate){
        return $object->sec*1000;//date('Y-m-d H:i:s', $object->sec);
      }

      if (!empty($properties)) {
        $className = get_class($object);
        if (!empty($properties[$className])) {
          $result = [];
          foreach ($properties[$className] as $key => $name) {
            if (is_int($key)) {
              $result[$name] = $object->$name;
            } else {
              $result[$key] = static::getValue($object, $name);
            }
          }

          return $recursive ? static::convertData($result) : $result;
        }
      }
      if ($object instanceof Arrayable) {
        $result = $object->toArray();
      } else {
        $result = [];
        foreach ($object as $key => $value) {
          $result[$key] = $value;
        }
      }

      return $recursive ? static::convertData($result) : $result;
    } else {
      return $object;
    }
  }

  /**
   * Retrieves the value of an array element or object property with the given key or property name.
   * If the key does not exist in the array or object, the default value will be returned instead.
   * @param type $array
   * @param type $key
   * @param type $default
   * @return type
   */
  public static function getValue($array, $key, $default = null) {
    
    if ($key instanceof \Closure) {
      return $key($array, $default);
    }
 
    if (is_array($array) && array_key_exists($key, $array)) {
     
      $len = count($array);
      //mongo id
      if($len === 1 && isset($array['$id'])){
        return $array['$id'];
      }elseif($len === 2 && isset($array['sec']) && isset($array['usec'])){
        //mongo date
        return $array['sec']*1000;//date('Y-m-d H:i:s',$array['sec']);
      }
      
      if (is_object($array[$key])) {
        if($array[$key] instanceof MongoId){
          return (string)$array[$key];
        }elseif($array[$key] instanceof \MongoDate){
          return $array[$key]->sec*1000;//date('Y-m-d H:i:s',$array[$key]->sec);
        }

        return $array->$key;
      }
      
      return $array[$key];
    }

    if (($pos = strrpos($key, '.')) !== false) {
      $array = static::getValue($array, substr($key, 0, $pos), $default);
      $key = substr($key, $pos + 1);
    }

    if (is_object($array)) {
      if($array instanceof MongoId){
        return (string)$array;
      }elseif($array instanceof \MongoDate){
        return $array->sec*1000;//date('Y-m-d H:i:s', $array->sec);
      }

      return $array->$key;
    } elseif (is_array($array)) {
      //check is array mongoobject

      return array_key_exists($key, $array) ? $array[$key] : $default;
    } else {
      return $default;
    }
  }

}
