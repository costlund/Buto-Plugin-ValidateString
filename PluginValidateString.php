<?php
/**
 * Validate string.
 */
class PluginValidateString{
  private $i18n = null;
  function __construct() {
    wfPlugin::includeonce('i18n/translate_v1');
    $this->i18n = new PluginI18nTranslate_v1();
    $this->i18n->setPath('/plugin/validate/string/i18n');
  }
  /**
   * Character validation.
   */
  public function validate_characters($field, $form, $data = array('characters' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_')){
    if(wfArray::get($form, "items/$field/is_valid" && isset($data['characters']))){
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
        $form = wfArray::set($form, "items/$field/errors/", $this->i18n->translateFromTheme("?label has invalid characters!", array('?label' => wfArray::get($form, "items/$field/label"))));
      }
    }
    return $form;
  }
  /**
   * Length validation.
   */
  public function validate_length($field, $form, $data = array('length' => 255)){
    if(wfArray::get($form, "items/$field/is_valid") && isset($data['length'])){
      $str = wfArray::get($form, "items/$field/post_value");
      $current_length = strlen(wfArray::get($form, "items/$field/post_value"));
      $length = $data['length'];
      if($current_length > $length){
        $form = wfArray::set($form, "items/$field/is_valid", false);
        $form = wfArray::set($form, "items/$field/errors/", $this->i18n->translateFromTheme("?label has a length of ?current_length where ?length is max!", array('?label' => wfArray::get($form, "items/$field/label"), '?length' => $length, '?current_length' => $current_length)));
      }
    }
    return $form;
  }
  /**
   * Length validation.
   * Will only check if string not empty.
   */
  public function validate_length_minmax($field, $form, $data = array('min' => 0, 'max' => 255)){
    if(wfArray::get($form, "items/$field/is_valid") && isset($data['min']) && isset($data['max'])){
      $strlen = strlen(wfArray::get($form, "items/$field/post_value"));
      $min = wfArray::get($data, 'min');
      $max = wfArray::get($data, 'max');
      if($strlen>0 && ($strlen<$min || $strlen>$max)){
        $form = wfArray::set($form, "items/$field/is_valid", false);
        $form = wfArray::set($form, "items/$field/errors/", $this->i18n->translateFromTheme("?label must have a length between ?min and ?max!", array('?label' => wfArray::get($form, "items/$field/label"), '?min' => $min, '?max' => $max)));
      }
    }
    return $form;
  }
}