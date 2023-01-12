<?php

namespace Drupal\specbee_assignment;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * TimezoneTime Service.
 */
class TimezoneTime {

  protected $configFactory;

  /**
   * Constructs an AliasManager.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   The config factory.
   */
  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->configFactory = $configFactory;
  }

  /**
   *
   */
  public function getTimezoneTime() {
    $config = $this->configFactory->get('specbee_assignment.settings');
    return $config->get('country');
  }

}
