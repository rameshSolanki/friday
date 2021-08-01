<?php

namespace Drupal\friday\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\HttpFoundation;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Database\Connection;

    /**
     * Provides a 'fridayBlock' block.
     *
     * @Block(
     *   id = "friday_block",
     *   admin_label = @Translation("friday block"),
     *   category = @Translation("Custom friday block")
     * )
    */
class FridayBlock extends BlockBase
{

    protected $loadData;

     /**
   * {@inheritdoc}
   */
    public function __construct()
    {
        $this->loadData = \Drupal::service('friday.data_handler');
    }

 /**
  * {@inheritdoc}
 */
    public function build()
    {

        $count = $this->loadData->getIpCount();
    
        $hasfield_ip_address = $this->loadData->getData();

        if (!$hasfield_ip_address) {
            $builtForm = \Drupal::formBuilder()->getForm('Drupal\friday\Form\FridayForm');
            $renderArray['form'] = $builtForm;

            return $renderArray;
        } else {
            $builtForm = \Drupal::formBuilder()->getForm('Drupal\friday\Form\FridayForm');
             return array(
            '#theme' => 'friday-visitor-block',
            '#visitors' => $count,
            '#form' => $builtForm,
            // '#type' => 'markup',
            // '#markup' => 'Site Visitors: ' .$count,
             );
        }
    }
    
      /**
   * {@inheritdoc}
   */
  // protected function blockAccess(AccountInterface $account) {
  //   return AccessResult::allowedIfHasPermission($account, 'access  content');
  // }
}
