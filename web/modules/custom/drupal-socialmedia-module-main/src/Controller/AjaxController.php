<?php

namespace Drupal\epic_social_media\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Drupal\epic_social_media\ClickManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AjaxController extends Controllerbase {

  protected $clickManager;

  public function __construct(ClickManager $clickManager) {
    $this->clickManager = $clickManager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('epic_social_media.click_manager')
    );
  }

  public function counter(Request $req)
  {
    if (!$this->currentUser()->hasPermission('skip tracking clicks')) {
      $res = $this->clickManager->addClick($req->get('network'));
    }

    if(!$res) {
      $res = "Something went wrong: "+ $res;
    }

    else {
      $res = "OK";
    }

    return [
      '#markup' => $res
    ];
  }
}
