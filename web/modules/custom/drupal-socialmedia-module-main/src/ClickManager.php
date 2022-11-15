<?php

namespace Drupal\epic_social_media;

use Drupal\Core\Database\Connection;
use Drupal\Component\Datetime\TimeInterface;


class ClickManager
{
    protected $con;
    protected $time;

    public function __construct(Connection $con, TimeInterface $time) {
        $this->con = $con;
        $this->time = $time;
    }

    function addClick($network) {
        $time = $this->time->getCurrentTime();
        $time = date('d/m/Y H:i:s',$time);      
        $res = $this->con->insert('epic_social_media_data')
        ->fields([
          'network' => $network,
          'time_clicked' => $time,
        ])
        ->execute();
    }

    function getClicks($network) {
        $res = $this->con->query("SELECT count(time_clicked) FROM epic_social_media_data WHERE network = '$network'")->fetchField();
        return $res;
    }    

    function removeClicks($network) {
        $res = $this->con->query("DELETE FROM epic_social_media_data WHERE network = '$network'")->execute();
        return $res;
    }    

    function getAllClicks() {
        $res = $this->con->query("SELECT network, count(time_clicked) FROM epic_social_media_data GROUP BY network")->fetchAll();
        return $res;
    }
}
