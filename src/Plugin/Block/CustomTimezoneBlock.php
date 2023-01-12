<?php

namespace Drupal\specbee_assignment\Plugin\Block;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\specbee_assignment\TimezoneTime;

/**
 * @file
 * Class for providing the Block plugin.
 */

/**
 * Provides a 'CustomTimezoneBlock' Block.
 *
 * @Block(
 *   id = "customTimezoneBlock",
 *   admin_label = @Translation("Custom Time zone Block"),
 *   category = @Translation("Specbee"),
 * )
 */
class CustomTimezoneBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * The config factory onject.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;
  /**
   * The TimezoneTime object.
   *
   * @var \Drupal\specbee_assignment\TimezoneTime
   */
  protected $timezoneTime;

  /**
   * Creates a CustomTimezoneBlock instance.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   Config Factory object.
   * @param \Drupal\specbee_assignment\TimezoneTime $timezoneTime
   *   TimezoneTime object.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $configFactory, TimezoneTime $timezoneTime) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $configFactory;
    $this->timezoneTime = $timezoneTime;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('specbee_assignment.timezone_time')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configFactory->get('specbee_assignment.settings');
    $city_country = $config->get('city') . ', ' . $config->get('country');
    $date = DrupalDateTime::createFromFormat('jS F Y - g:i A', $this->timezoneTime->getTimezoneTime());
    return [
      '#time' => $date->format('g:i a', ['timezone' => $config->get('timezone')]),
      '#date' => $date->format('l, j M Y', ['timezone' => $config->get('timezone')]),
      '#location' => $city_country,
      '#theme' => 'specbee_assignment_block',
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

}
