<?php

namespace Drupal\epic_social_media\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\State\StateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\epic_social_media\ClickManager;

/**
 * Provides a 'social media' Block.
 *
 * @Block(
 *   id = "epic_social_media_block",
 *   admin_label = @Translation("Epic social media"),
 *   category = @Translation("Custom block"),
 * )
 */

class SocialMediaBlock extends BlockBase implements ContainerFactoryPluginInterface{
  /**
   * {@inheritdoc}
   */
  protected $state;
  protected $clickManager;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, ClickManager $clickManager, StateInterface $state){
    parent::__construct($configuration, $plugin_id, $plugin_definition);

    $this->state = $state;
    $this->clickManager = $clickManager;
  }
  
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('epic_social_media.click_manager'),
      $container->get('state')
    );
  }

  public function build() {
    return [
      '#theme' => 'epic-social-media',
      '#name' => 'epic-social-media',
      '#facebook_url' =>  $this->state->get('epic_social_media.facebook_url'),
      '#google_url' =>  $this->state->get('epic_social_media.google_url'),
      '#twitter_url' =>  $this->state->get('epic_social_media.twitter_url'),
      '#linkedin_url' =>  $this->state->get('epic_social_media.linkedin_url'),

      '#facebook_count' => $this->clickManager->getClicks('facebook'),
      '#google_count' => $this->clickManager->getClicks('google'),
      '#twitter_count' => $this->clickManager->getClicks('twitter'),
      '#linkedin_count' => $this->clickManager->getClicks('linkedin'),

      '#attached' => [
        'library' => [
          'epic_social_media/epic_social_media',
        ],
      ],
    ];
  }
}
