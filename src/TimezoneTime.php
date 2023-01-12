<?php

namespace Drupal\specbee_assignment;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Timezone Time Service.
 */
class TimezoneTime {

  /**
   * The config factory onject.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;
  /**
   * The date formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Constructs an AliasManager.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config factory.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $dateFormatter
   *   The date formatter service.
   */
  public function __construct(ConfigFactoryInterface $configFactory, DateFormatterInterface $dateFormatter) {
    $this->configFactory = $configFactory;
    $this->dateFormatter = $dateFormatter;
  }

  /**
   * Get Time based on timezone set in admin.
   */
  public function getTimezoneTime() {
    $config = $this->configFactory->get('specbee_assignment.settings');
    $datetime = DrupalDateTime::createFromTimestamp(time(), $config->get('timezone'));
    $result = $this->dateFormatter->format($datetime->getTimestamp(), 'custom', 'jS F Y - g:i A');
    return $result;
  }

}
