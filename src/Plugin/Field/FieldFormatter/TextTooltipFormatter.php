<?php

namespace Drupal\ut_text_formatters\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'Tooltip' formatter.
 *
 * @FieldFormatter(
 *   id = "tootlip",
 *   label = @Translation("Tooltip"),
 *   field_types = {
 *     "string", "list_string", "text_with_summary",
 *     "text_long", "string_long", "text"
 *   }
 * )
 */
class TextTooltipFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'tooltip_content' => 'default tooltip content',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['tooltip_content'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Manage the content of the tooltip.'),
      '#default_value' => $this->getSetting('tooltip_content'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#theme' => 'text_tooltip_formatter',
        '#text' => $item->value,
        '#tooltip_content' => $this->getSetting('tooltip_content'),
        '#attached' => [
          'library' => [
            'ut_text_formatters/ut_text_formatters.qtip',
          ],
        ],
      ];
    }
    return $elements;

  }

}
