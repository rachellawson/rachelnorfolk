<?php

declare(strict_types=1);

namespace Drupal\orienteer\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides an Orienteer form that records visits.
 *
 * This form exists at the URL stored in the qrcode on the info board
 * created for a Location. By having the params in the url, we fill
 * in most of the info needed.
 */
final class VisitLocationForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'orienteer_visit_location';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, ?string $first_name = NULL, ?string $second_name = NULL, ?string $secret = NULL): array {

    $form['message'] = [
      '#type' => 'item',
      '#markup' => $this->t('Please enter the names on the location card, along with the secret number.'),
    ];

    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First name'),
      '#required' => TRUE,
      '#value' => $first_name,
    ];

    $form['second_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Second name'),
      '#required' => TRUE,
      '#value' => $second_name,
    ];

    $form['secret'] = [
      '#type' => 'number',
      '#title' => $this->t('Secret number'),
      '#required' => TRUE,
      '#value' => $secret,
    ];

    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // @todo Validate the form here.
    // Probably along the lines of:
    // - find the terms that match the names
    // - find the location that contains both terms
    // - if can't be found, say it can't be found - maybe typo?
    // - does it have the same secret number - say so.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->messenger()->addStatus($this->t('The message has been sent.'));

    // @todo Add the Visit.
    // There might be events we want to fire.
    // Finally, redirect to the visit canonical page, that includes a map and
    // a congratulations.
    $form_state->setRedirect('<front>');
  }

}
