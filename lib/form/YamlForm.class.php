<?php

/**
 * YamlForm is the base class for YAML compatible forms.
 *
 * @package    yamlCss
 * @subpackage form
 * @author     Yevgeniy A. Viktorov <wik@osmonitoring.com>
 */
class YamlForm extends sfForm
{
  public function render($attributes = array())
  {
    $this->widgetSchema->setDefaultFormFormatterName('yaml');
    $formatterObj = $this->widgetSchema->getFormFormatter();

    if(!is_null($formatterObj)) {
      $formatterObj->setValidatorSchema($this->getValidatorSchema());
      $this->widgetSchema->getFormFormatter()->setTranslationCatalogue("register_store_form");
    }

    return parent::render($attributes);
  }
}
