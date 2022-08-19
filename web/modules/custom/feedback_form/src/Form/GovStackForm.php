<?php

namespace Drupal\feedback_form\Form;

use Drupal;
use Drupal\Core\Url;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

/**
 * Provides a Feedback Form form.
 */
class GovStackForm extends FormBase
{

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'feedback_form_gov_stack';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {

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
      encoded format on our issue management systems. We may use it to ask for
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
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    if (mb_strlen($form_state->getValue('email')) < 5) {
      $form_state->setErrorByName('name', $this->t('Email should be at least 5 characters.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {

    // Encode email address.
    // Base64 enough at this stage, so it looks like 
    // Rachel Lawson (cmFjaGVsbGF3c29uQG1lLmNvbQ==).
    $encoded_email = base64_encode($form_state->getValue('email'));

    // Determine which repo we want to write to.
    $repo = $this->findRepo($form_state->getValue('referrer'));

    // Get connection to GitHub.
    $auth_token = \Drupal::config('feedback_form.settings')->get('token');

    $data = [];
    $data['title'] = 'Feedback on specifications, submitted by ' . $form_state->getValue('name');
    $data['body'] =  '<h2>' . $form_state->getValue('name') . ' (' 
      . $encoded_email . ')' . ' submitted the following feedback:</h2> <br />' 
      . '<em>Looking at page: ' . $form_state->getValue('referrer') . '</em><br />'
      . $form_state->getValue('feedback');
    $encoded_data = json_encode($data);

    try {
      $url = 'https://api.github.com/repos' . $repo . '/issues';

      $response = \Drupal::httpClient()->post($url, [
        'body' => $encoded_data,
        'headers' => [
          'Accept' => "application/vnd.github+json",
          'Authorization' => 'token ' . $auth_token
        ]
      ]);

      $response_data = json_decode($response->getBody()->getContents());
      $issue_link = $response_data->html_url;

      // Report back on success, including link to issue.
      $this->messenger()->addStatus($this->t(
        'We have added an <a href="@issue_link">issue</a> in our issue list to follow up on your feedback. Thank you!',
        ['@issue_link' => Url::fromUri($issue_link)->toString(),]
      ));
    } catch (RequestException $e) {
      // log exception
      $this->messenger()->addStatus($this->t('ooerr - it went wrong!'));
      \Drupal::logger('feedback_form')->error($e->getResponse()->getBody()->getContents());
    }


    $form_state->setRedirect('feedback_form.gov_stack');
  }

  /**
   * Find a sensible Building Block name from the referrer url.
   * 
   * @param string $referrer
   * The referrer url.
   */
  private function findRepo($referrer)
  {

    $base_github_org = '/GovstackWorkingGroup/';

    if (mb_ereg('\/(bb-[a-z|-]*)', $referrer, $matches)) {
      return $base_github_org . $matches[1];
    }

    // If we don't know which BB from the URL, assume the specifications repo
    // and move on from there.
    return $base_github_org . 'specifications';
  }
}
