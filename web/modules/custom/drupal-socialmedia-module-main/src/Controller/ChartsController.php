<?php

namespace Drupal\epic_social_media\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Render\FormattableMarkup;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Drupal\epic_social_media\ClickManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ChartsController extends Controllerbase 
{
    protected $clickManager;

    function __construct(ClickManager $clickManager) {
        $this->clickManager = $clickManager;
    }

    public static function create(ContainerInterface $container) {
        return new static(
          $container->get('epic_social_media.click_manager')
        );
    }

    public function buildCharts() {
        return [
            '#markup' => new FormattableMarkup('<div id="chart" style="width: 900px; height: 500px;">Chart will be displayed here.</div>', []),
            '#attached' => [
                'library' => ['epic_social_media/data_charts'],
                'drupalSettings' => [
                    'chart_data' => [
                        'facebook' => $this->clickManager->getClicks('facebook'),
                        'linkedin' => $this->clickManager->getClicks('linkedin'),
                        'twitter' => $this->clickManager->getClicks('twitter'),
                        'google' => $this->clickManager->getClicks('google'),
                    ],
                ],
            ],            
        ];
    }
}
