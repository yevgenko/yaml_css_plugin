<?php

/**
 * Html tools
 *
 * @package    yamlCss
 * @subpackage tools
 * @author     Yevgeniy A. Viktorov <wik@osmonitoring.com>
 */
class yamlCssHtml
{
  /**
   * Retrieves html tag name from a string
   *
   * @param   string  $src The input string, html source code
   *
   * @return  string  The tag name or a blank string if the wasn't found
   */
  public static function getTagName($src)
  {
    $result = '';

    if ($src != ''){
      // Retrieves the attribute required
      preg_match('/^<([a-z]+)/i', $src, $match);
      $result = (isset($match[1])) ? $match[1] : '';
    }

    return $result;
  }

  /**
   * Retrieves html attribute value from a string
   *
   * @param   string  $src The input string, html source code
   * @param   string  $attribute  The attribute name to search for
   *
   * @return  string  The attribute value or a blank string if the wasn't found
   */
  public static function getTagAttribute($src, $attribute)
  {
    $result = '';

    if ($src != '' && $attribute != ''){
      // Retrieves the attribute required
      preg_match('/' . $attribute . '\s*=\s*["|\'](.*?)["|\'].*?/i', $src, $match);
      $result = (isset($match[1])) ? $match[1] : '';
    }

    return $result;
  }
}
