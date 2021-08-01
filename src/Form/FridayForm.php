<?php
/**
 * @file
 * Contains \Drupal\friday\Form\FridayForm.
 */

namespace Drupal\friday\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Session\AccountProxyInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\Database\Connection;

class FridayForm extends FormBase
{

  /**
   * Current user account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
    protected $currentUser;

  /**
   * Node storage.
   *
   * @var \Drupal\node\NodeStorageInterface
   */
    protected $nodeManager;

    protected $loadData;

  /**
   * {@inheritdoc}
   */
    public function __construct(
        EntityTypeManager $entity_type_manager,
        AccountProxyInterface $current_user
    ) {
        $this->currentUser = $current_user;
        $this->nodeManager = $entity_type_manager->getStorage('node');
        $this->loadData = \Drupal::service('friday.data_handler');
    }

  /**
   * {@inheritdoc}
   */
    public static function create(ContainerInterface $container)
    {
        return new static(
            $container->get('entity_type.manager'),
            $container->get('current_user')
        );
    }

  /**
   * {@inheritdoc}
   */
    public function getFormId()
    {
        return 'friday_form';
    }

  /**
   * {@inheritdoc}
   */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $current_time = \Drupal::time()->getCurrentTime();
        $date_output = date('d-m-Y h:i:s A', $current_time);

        $form['#prefix'] = '<div class="visually-hidden">';

        $form['title'] =  [
        '#type' => 'textfield',
        '#default_value' =>$date_output,
        // '#description' => $this->t('Enter your title here!'),
        // '#attributes' => array('class' => array('visually-hidden')),
        ];

        $form['ip_address'] =  [
        '#type' => 'textfield',
        '#default_value' =>\Drupal::request()->getClientIp(),
      // '#description' => $this->t('Enter your IP here!'),
      // '#attributes' => array('class' => array('visually-hidden')),
        ];
    

        $form['actions']['#type'] = 'actions';

        $form['actions']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Save data'),
      // '#attributes' => array('class' => array('visually-hidden')),
        ];

        $form['#suffix'] = '</div>';

        return $form;
    }

  /**
   * {@inheritdoc}
   */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
    }

  /**
   * {@inheritdoc}
   */
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $current_time = \Drupal::time()->getCurrentTime();
        $date_output = date('d-m-Y h:i:s A', $current_time);

        $field_ip_address = \Drupal::request()->getClientIp();
        $connection = \Drupal::database();

        $hasfield_ip_address = $this->loadData->getData();

        // echo '<pre>';
        // print_r($hasfield_ip_address);
        // echo  '</pre>';

        if (!$hasfield_ip_address) {
        // Initialise a node object with several field values.
      
              $hasfield_ip_address = $this->loadData->setData();
        }
    }
}
