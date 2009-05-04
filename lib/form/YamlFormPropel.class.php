<?php

/**
 * YamlFormPropel is the base class for YAML compatible forms based on Propel objects.
 *
 * @package    yamlCss
 * @subpackage form
 * @author     Yevgeniy A. Viktorov <wik@osmonitoring.com>
 */
abstract class YamlFormPropel extends sfFormPropel
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
