<?php

namespace Drupal\epic_social_media\Form;

use Drupal\Core\Form\Formbase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use \Drupal\Core\Form\FormInterface;
use \Drupal\Core\State\StateInterface;
use Drupal\epic_social_media\ClickManager;

class SettingsForm extends FormBase {

  protected $state;
  protected $clickManager;

  public function __construct(StateInterface $state, ClickManager $clickManager) {
    $this->state = $state;
    $this->clickManager = $clickManager;
  }

  public function getFormId()
  {
    return 'epic_social_media_settings_form';
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('state'),
      $container->get('epic_social_media.click_manager')
    );
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {

    // Per social media
    $form['facebook_actions'] = [
      '#type' => 'actions',
    ];

    $form['linkedin_actions'] = [
      '#type' => 'actions',
    ];

    $form['twitter_actions'] = [
      '#type' => 'actions',
    ];

    $form['google_actions'] = [
      '#type' => 'actions',
    ];

    $form['facebook_actions']['facebook_url'] = [
      '#type' => 'url',
      '#title' => 'Facebook url',
      '#placeholder' => 'Your URL',
      '#default_value' => $this->state->get('epic_social_media.facebook_url'),
    ];
    $form['facebook_actions']['facebook_reset'] = [
      '#type' => 'checkbox',
      '#title' => 'Reset counter'
    ];


    $form['google_actions']['google_url'] = [
      '#type' => 'url',
      '#title' => 'Google+ url',
      '#placeholder' => 'Your URL',
      '#default_value' => $this->state->get('epic_social_media.google_url'),
    ];

    $form['google_actions']['google_reset'] = [
      '#type' => 'checkbox',
      '#title' => 'Reset counter'
    ];


    $form['twitter_actions']['twitter_url'] = [
      '#type' => 'url',
      '#title' => 'Twitter url',
      '#placeholder' => 'Your URL',
      '#default_value' => $this->state->get('epic_social_media.twitter_url'),
    ];

    $form['twitter_actions']['twitter_reset'] = [
      '#type' => 'checkbox',
      '#title' => 'Reset counter'
    ];


    $form['linkedin_actions']['linkedin_url'] = [
      '#type' => 'url',
      '#title' => 'LinkedIn url',
      '#placeholder' => 'Your URL',
      '#default_value' => $this->state->get('epic_social_media.linkedin_url'),
    ];

    $form['linkedin_actions']['linkedin_reset'] = [
      '#type' => 'checkbox',
      '#title' => 'Reset counter'
    ];


    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $allUrls = array();
    $allResets = array();
    $formItems = $form_state->getValues();
    $resetMsg = "";

    // Loops through form items for URL items & adds to array
    foreach($formItems as $key => $item) {
      if(stristr($key, 'url') != false) {
        $allUrls[$key]= $item;
      }
    }

    // Loops through form items for resets & adds to array
    foreach($formItems as $key => $item) {
      if(stristr($key, 'reset') != false) {
        $key = str_replace('_reset','',$key);
        $allResets[$key]= $item;
      }
    }

    // Loops through url array and sets/stores states
    foreach($allUrls as $key => $socialMedia) {
      $this->state->set('epic_social_media.'.$key,$form_state->getValue($key));
    }

    // Loops through reset array and applies query if enabled in form
    foreach($allResets as $socialMedia => $enabled) {
      if($enabled) {
        $this->clickManager->removeClicks($socialMedia);
        $resetMsg = "The selected platforms were reset.";
      }
    }

    $this->messenger()->addStatus($this->t("All the url's has been applied. " . $resetMsg));
  }
}
