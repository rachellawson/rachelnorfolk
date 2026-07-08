<?php

declare(strict_types=1);

namespace Drupal\rachelnorfolk_custom\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * A small event subscriber to add security headers.
 */
final class CstsSubscriber implements EventSubscriberInterface {

  /**
   * Response object.
   *
   * @var \Symfony\Component\HttpFoundation\Response
   */
  protected $response;

  /**
   * Send people immediately to https.
   */
  public function onKernelResponse(ResponseEvent $event): void {
    $this->response = $event->getResponse();
    $this->response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      KernelEvents::RESPONSE => ['onKernelResponse'],
    ];
  }

}
