<?php

namespace Drupal\sy_mapping\TwigExtension;

use Drupal\Core\Site\Settings;

class TwigUtil extends \Twig_Extension {

  /**
   * {@inheritdoc}
   */
  public function getFilters() {
    $filters = [
      new \Twig_SimpleFilter('hex_to_rgb', [$this, 'hexToRgb']),
    ];

    return $filters;
  }

  public function hexToRgb($color, $alpha = null)
  {
    $color = self::_checkHex($color);
    if (!$color) return $color;
    // Convert HEX to DEC
    $R = hexdec($color[0].$color[1]);
    $G = hexdec($color[2].$color[3]);
    $B = hexdec($color[4].$color[5]);

    $RGB['R'] = $R;
    $RGB['G'] = $G;
    $RGB['B'] = $B;
    $type = 'rgb';
    if ($alpha) {
      $RGB['A'] = $alpha;
      $type = 'rgba';
    }
    return  $type . '(' . implode(",", $RGB) . ')';
  }

  /**
  * You need to check if you were given a good hex string
  * @param string $hex
  * @return string Color
  */
  private static function _checkHex( $hex ) {
    // Strip # sign is present
    $color = str_replace("#", "", $hex);
    // Make sure it's 6 digits
    if( strlen($color) == 3 ) {
      $color = $color[0].$color[0].$color[1].$color[1].$color[2].$color[2];
    } else if( strlen($color) != 6 ) {
      return false;
    }
    return $color;
  }

  /**
   * Gets a unique identifier for this Twig extension.
   */
  public function getName() {
    return 'twig_util';
  }

}