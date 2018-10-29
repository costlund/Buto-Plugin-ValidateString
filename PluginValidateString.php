<?php
/**
 * Validate string.
 */
class PluginValidateString{
  /**
   * Character validation.
   */
  public function validate_characters($field, $form, $data = array('characters' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVwXYZ0123456789_')){
    if(wfArray::get($form, "items/$field/is_valid")){
      $str = wfArray::get($form, "items/$field/post_value");
      $error = false;
      for($i=0;$i<strlen($str);$i++){
        $j = substr($str, $i, 1);
        if(!strstr($data['characters'], $j)){
          $error = true;
          break;
        }
      }
      if($error){
        $form = wfArray::set($form, "items/$field/is_valid", false);
        $form = wfArray::set($form, "items/$field/errors/", __("?label has invalid characters!", array('?label' => wfArray::get($form, "items/$field/label"))));
      }
    }
    return $form;
  }
  /**
   * Length validation.
   */
  public function validate_length($field, $form, $data = array('length' => 255)){
    if(wfArray::get($form, "items/$field/is_valid")){
      $str = wfArray::get($form, "items/$field/post_value");
      $current_length = strlen(wfArray::get($form, "items/$field/post_value"));
      $length = $data['length'];
      if($current_length > $length){
        $form = wfArray::set($form, "items/$field/is_valid", false);
        $form = wfArray::set($form, "items/$field/errors/", __("?label has a length of ?current_length where ?length is max!", array('?label' => wfArray::get($form, "items/$field/label"), '?length' => $length, '?current_length' => $current_length)));
      }
    }
    return $form;
  }
}