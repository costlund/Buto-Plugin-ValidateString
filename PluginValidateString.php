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
    $data = new PluginWfArray($data);
    if(wfArray::get($form, "items/$field/is_valid") && $data->get('characters')){
      $str = wfArray::get($form, "items/$field/post_value");
      $error = false;
      for($i=0;$i<strlen($str);$i++){
        $j = wfPhpfunc::substr($str, $i, 1);
        if(!$data->get('disallow')){
          if(!wfPhpfunc::strstr($data->get('characters'), $j)){
            $error = true;
            break;
          }
        }else{
          if(wfPhpfunc::strstr($data->get('characters'), $j)){
            $error = true;
            break;
          }
        }
      }
      if($error){
        $form = wfArray::set($form, "items/$field/is_valid", false);
        if(!$data->get('disallow')){
          $error_message = $this->i18n->translateFromTheme("?label can only have characters like ?characters!", array('?label' => wfArray::get($form, "items/$field/label"), '?characters' => $data->get('characters')));
        }else{
          $error_message = $this->i18n->translateFromTheme("?label can not have any characters like ?characters!", array('?label' => wfArray::get($form, "items/$field/label"), '?characters' => $data->get('characters')));
        }
        $form = wfArray::set($form, "items/$field/errors/", $error_message);
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
      $current_length = wfPhpfunc::strlen(wfArray::get($form, "items/$field/post_value"));
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
    $data = new PluginWfArray($data);
    /**
     * 
     */
    if($data->get('min') && !$data->get('max')){
      $data->set('max', $data->get('min'));
    }
    /**
     * 
     */
    if(wfArray::get($form, "items/$field/is_valid") && $data->get('min') && $data->get('max')){
      $strlen = wfPhpfunc::strlen(wfArray::get($form, "items/$field/post_value"));
      $min = $data->get('min');
      $max = $data->get('max');
      if($strlen>0 && ($strlen<$min || $strlen>$max)){
        $form = wfArray::set($form, "items/$field/is_valid", false);
        /**
         * 
         */
        if($min != $max){
          $message = "?label must have a length between ?min and ?max!";
        }else{
          $message = "?label must have a length of ?min!";
        }
        $form = wfArray::set($form, "items/$field/errors/", $this->i18n->translateFromTheme($message, array('?label' => wfArray::get($form, "items/$field/label"), '?min' => $min, '?max' => $max)));
      }
    }
    /**
     * 
     */
    return $form;
  }
}
