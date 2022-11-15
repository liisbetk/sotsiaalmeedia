<?php

namespace Drupal\module_hero\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactory;

/**
 * This is our hero controller.
 */
class HeroController extends ControllerBase{

    private $articleHeroService;
    protected $configFactory;

    public static function create(ContainerInterface $container){
        return new static($container->get('module_hero.hero_articles'),
        $container->get('config.factory')
    );
    }

    public function __construct(configFactory $configFactory){

        $this->configFactory = $configFactory;
    }

    public function heroList() {

        $heroes = [
        ['name' => 'Hulk'],
        ['name' => 'Thor'],
        ['name' => 'Iron Man'],
        ['name' => 'Luke Cage'],
        ['name' => 'Black Widow'],
        ['name' => 'Daredevil'],
        ['name' => 'Captain America'],
        ['name' => 'Wolverine']
        ];

        return [
            '#theme' => 'hero_list',
            '#items' => $heroes,
            '#title' => $this->t('Our wonderful heroes list'),
        ];

    }
}
