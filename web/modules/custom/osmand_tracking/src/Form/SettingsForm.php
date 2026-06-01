<?php

declare(strict_types=1);

namespace Drupal\osmand_tracking\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure OsmAnd Tracking settings for this site.
 */
final class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'osmand_tracking_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['osmand_tracking.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['secret'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Tracking url secret'),
      '#default_value' => $this->config('osmand_tracking.settings')->get('secret'),
      '#description' => $this->t('This value will be used in the url that must be entered into the OsmAnd app for it to post new track points. It reduces the likelihood of receiving points erroneously.'),
      '#required' => TRUE,
      '#size' => 10,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // @todo check for valid text.
    if (!preg_match('/^[a-zA-Z0-9\-]*$/', $form_state->getValue('secret'))) {
      $form_state->setErrorByName(
        'secret',
        $this->t('The secret field must contain text that is valid in a url.'),
      );
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->config('osmand_tracking.settings')
      ->set('secret', $form_state->getValue('secret'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
