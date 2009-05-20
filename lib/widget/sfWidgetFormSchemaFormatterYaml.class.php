<?php

/**
 * sfWidgetFormSchemaFormatterYaml allows to format a form schema with YAML compatible HTML formats.
 *
 * @see http://www.yaml.de/en/home.html
 *
 * @package    yamlCss
 * @subpackage widget
 * @author     Yevgeniy A. Viktorov <wik@osmonitoring.com>
 */
class sfWidgetFormSchemaFormatterYaml extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat       = "<div class=\"type-%type%\">\n  %error%%label%\n
%field%%help%\n%hidden_fields%</div>\n",
    $errorListFormatInARow     = "\n%errors%\n",
    $errorRowFormatInARow      = "&nbsp;<strong class=\"message\">%error%</strong>\n",
    $namedErrorRowFormatInARow = "&nbsp;<strong class=\"message\">%name%: %error%</strong>\n",
    $helpFormat      = '<span class="help">%help%</span><br/>',
    $decoratorFormat = "<div>\n  %content%</div>",
    $requiredTemplate= '&nbsp;<sup title="This field is mandatory.">*</sup>',
    $validatorSchema = null;

  public function formatRow($label, $field, $errors = array(), $help = '', $hiddenFields = null)
  {
    $error = $this->formatErrorsForRow($errors);
    $type = $this->getFieldType($field);

    return strtr($this->getRowFormat(), array(
      '%type%'         =>  $type.(!empty($error)?' error':''),
      '%label%'         => $label,
      '%field%'         => $field,
      '%error%'         => $error,
      '%help%'          => $this->formatHelp($help),
      '%hidden_fields%' => is_null($hiddenFields) ? '%hidden_fields%' : $hiddenFields,
    ));
  }

  /**
   * Generates the label name for the given field name.
   *
   * @param  string $name  The field name
   *
   * @return string The label name
   */
  public function generateLabelName($name)
  {
    $label = parent::generateLabelName($name);

    if(!is_null($this->validatorSchema)) {
      $fields = $this->validatorSchema->getFields();
      if(isset($fields[$name]) && $fields[$name] != null) {
        $field = $fields[$name];
        if($field->hasOption('required') && $field->getOption('required')) {
          $label .= $this->requiredTemplate;
        }
      }
    }

    return $label;
  }

  /**
   * Sets the validator schema associated with this formatter instance.
   *
   * @param sfValidatorSchema $widgetSchema A sfValidatorSchema instance
   */
  public function setValidatorSchema(sfValidatorSchema $validatorSchema)
  {
    $this->validatorSchema = $validatorSchema;
  }

  /**
   * Retrieves YAML compatible field type from a string.
   *
   * @param  string $field  The input string, html source code
   *
   * @return string The YAML compatible field type
   */
  public function getFieldType($field)
  {
    $type = 'text';
    switch (yamlCssHtml::getTagName($field))
    {
      case 'select':
        $type = 'select';
      break;

      case 'input':
        switch (yamlCssHtml::getTagAttribute($field, 'type'))
        {
          case 'checkbox':
          case 'radio':
            $type = 'check';
          break;
        }
      break;
    }

    return $type;
  }
}
