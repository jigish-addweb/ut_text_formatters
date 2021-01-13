<?php

namespace Drupal\ut_text_formatters;

use Cocur\Slugify\Slugify;

/**
 * Text Slugify Class.
 */
class TextSlugify {

  /**
   * The slugify object.
   *
   * @var slugify
   */
  protected $slugify;

  /**
   * Create an instance of Slugify.
   */
  public function __construct() {
    $this->slugify = new Slugify();
  }

  /**
   * {@inheritdoc}
   */
  public function textToSlug($string, $separator) {
    return $this->slugify->slugify($string, $separator);
  }

}
