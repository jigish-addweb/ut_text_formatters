<?php

namespace Drupal\ut_text_formatters\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\ut_text_formatters\TextSlugify;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Plugin implementation of the 'Slugify' formatter.
 *
 * @FieldFormatter(
 *   id = "slugify",
 *   label = @Translation("Slugify"),
 *   field_types = {
 *     "string", "list_string", "text_with_summary",
 *     "text_long", "string_long", "text"
 *   }
 * )
 */
class TextSlugifyFormatter extends FormatterBase implements ContainerFactoryPluginInterface {

  /**
   * The Slug service.
   *
   * @var \Drupal\ut_text_formatters\TextSlugify
   */
  protected $slugify;

  /**
   * Constructs a \Drupal\ut_text_formatters\TextSlugify object.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Any third party settings settings.
   * @param \Drupal\ut_text_formatters\TextSlugify $slugify
   *   Injected slugify service.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, TextSlugify $slugify) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);
    $this->slugify = $slugify;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
        $plugin_id,
        $plugin_definition,
        $configuration['field_definition'],
        $configuration['settings'],
        $configuration['label'],
        $configuration['view_mode'],
        $configuration['third_party_settings'],
        $container->get('ut_text_formatters.slugify'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'separator' => '-',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['separator'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Specify the separator for the text'),
      '#size' => 5,
      '#default_value' => $this->getSetting('separator'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    $separator = $this->getSetting('separator');
    $summary[] = $this->t('The separator is: "@separator"', ['@separator' => $separator]);

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    $separator = $this->getSetting('separator');

    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#markup' => $this->slugify->textToSlug($item->value, $separator),
      ];
    }

    return $elements;
  }

}
