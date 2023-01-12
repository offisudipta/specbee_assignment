<?php

namespace Drupal\specbee_assignment\Plugin\Block;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\specbee_assignment\TimezoneTime;

/**
 * @file
 *
 * Class for providing the Block plugin.
 */

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "hello_block",
 *   admin_label = @Translation("Hello block"),
 *   category = @Translation("Hello World"),
 * )
 */
class CustomTimezoneBlock extends BlockBase implements ContainerFactoryPluginInterface
{
  protected $configFactory;
  protected $timezoneTime;
  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Config\ConfigFactoryInterface $account
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, ConfigFactoryInterface $configFactory, TimezoneTime $timezoneTime)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $configFactory;
    $this->timezoneTime = $timezoneTime;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('specbee_assignment.timezone_time')
    );
  }

  public function build()
  {
    return [
      '#markup' => $this->timezoneTime->getTimezoneTime(),
    ];
  }
}
