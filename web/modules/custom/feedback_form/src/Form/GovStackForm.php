<?php

namespace Drupal\feedback_form\Form;

use Drupal;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Feedback Form form.
 */
class GovStackForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'feedback_form_gov_stack';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $form['welcome'] = [
      '#type' => 'item',
      '#markup' => $this->t('<p>Thank you for giving your feedback. We have a short form
      that will allow you to submit your feedback and be linked to the processes 
      we use to accept that feedback.</p>'),
    ];
    
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('What should we call you?'),
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('What is your email address?'),
      '#description' => $this->t('We will store your email address in an 
      encrypted format on our issue management systems. We may use it to ask for
      further information/clarification about your feedback.'),
      '#required' => TRUE,
    ];
    
    $ref_url_string = \Drupal::request()->headers->get('referer');
    $form['referrer'] = [
      '#type' => 'textfield',
      '#title' => $this->t('What page are you interested in?'),
      '#description' => $this->t('We have pre-filled this with the page
        you were viewing when you clicked on the feedback link but you 
        can change as necessary. We use this information to decide which
        of our maintainers would be able to help the most.'),
      '#default_value' => $ref_url_string,
      '#required' => TRUE,
    ];

    $form['feedback'] = [
      '#type' => 'textarea',
      '#title' => $this->t('What feedback do you have?'),
      '#required' => TRUE,
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send feedback'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (mb_strlen($form_state->getValue('email')) < 5) {
      $form_state->setErrorByName('name', $this->t('Email should be at least 5 characters.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus($this->t('The feedback has been sent. Thank you!'));
    $form_state->setRedirect('feedback_form.example');
  }

}
