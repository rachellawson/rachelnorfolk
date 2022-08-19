<?php

namespace Drupal\feedback_form\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure Feedback Form settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'feedback_form_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['feedback_form.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['token'] = [
      '#type' => 'textfield',
      '#title' => $this->t('GitHub Token'),
      '#default_value' => $this->config('feedback_form.settings')->get('token'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('feedback_form.settings')
      ->set('token', $form_state->getValue('token'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
