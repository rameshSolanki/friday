<?php
namespace Drupal\friday;

use Drupal\Core\Database\Connection;

/**
 * LoadData class for get and set data for form.
 */
class LoadData
{
    /**
   * @var \Drupal\Core\Database\Connection $database
   */
    protected $database;

    /**
   * Constructs a new DrupaliseMe object.
   * @param \Drupal\Core\Database\Connection $connection
   */
    
    public function __construct(Connection $database)
    {
        $this->database = $database;
    }

     /**
   * Returns list of nids from node table.
   */

    public function setData()
    {
        $current_time = \Drupal::time()->getCurrentTime();
        $field_ip_address = \Drupal::request()->getClientIp();

        $query = $this->database->insert('friday_visitor')
              ->fields([
                'ip_address',
                'created'
              ])
               ->values([
              'ip_address' => $field_ip_address,
              'created' => $current_time,
              ])
              ->execute();

              return $query;
    }


    public function getData()
    {
        $field_ip_address = \Drupal::request()->getClientIp();
        $query = $this->database->select('friday_visitor', 'f')
             ->fields('f', ['ip_address'])
             ->condition('ip_address', $field_ip_address, '=');
    
        $hasfield_ip_address = $query->execute()->fetchAll();

        return $hasfield_ip_address;
    }

    public function getIpCount()
    {
        $query = $this->database->query('Select * from friday_visitor');
        $query->allowRowCount = true;
        $count = $query->rowCount();

        return $count;
    }
}
