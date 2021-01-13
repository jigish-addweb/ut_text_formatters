<?php

namespace Drupal\ut_text_formatters\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'Rot13Encoding' formatter.
 *
 * @FieldFormatter(
 *   id = "rot13",
 *   label = @Translation("ROT13 Encoder"),
 *   field_types = {
 *     "string", "list_string", "text_with_summary",
 *     "text_long", "string_long", "text"
 *   }
 * )
 */
class TextRot13Formatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#markup' => $this->rot13Encoder($item->value),
      ];
    }

    return $elements;
  }

  /**
   * Generate ROT13 Encoded field item.
   *
   * @param string $value
   *   The field item value.
   *
   * @return string
   *   The ROT13 Encoded string.
   */
  private function rot13Encoder(string $value): string {
    $characters = str_split($value);
    foreach ($characters as $key => $char) {
      $character = ord($char);
      if ($character >= ord('a') && $character <= ord('m') || $character >= ord('A') && $character <= ord('M')) {
        $character += 13;
      }
      elseif ($character >= ord('n') && $character <= ord('z') || $character >= ord('N') && $character <= ord('Z')) {
        $character -= 13;
      }
      $characters[$key] = chr($character);
    }
    return implode($characters);
  }

}
