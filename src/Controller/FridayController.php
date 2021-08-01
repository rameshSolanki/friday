<?php

/**
 * @file
 * @author Rakesh James
 * Contains \Drupal\friday\Controller\FridayController.
 * Please place this file under your example(module_root_folder)/src/Controller/
 */

namespace Drupal\friday\Controller;

use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Component\Serialization\Json;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Provides route responses for the Example module.
 */
class FridayController
{
  /**
   * Returns a simple page.
   *
   * @return array
   *   A simple renderable array.
   */
    public function friday()
    {

        $ip_address = \Drupal::request()->getClientIp();

        return array(
        '#type' => 'markup',
        '#markup' => 'Your Ip: ' .$ip_address,
        );
    }
}
