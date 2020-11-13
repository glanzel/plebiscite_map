<?php
/* SVN FILE: $Id$ */
namespace App\Model\Table;

use Cake\ORM\Table;

class AppTable extends Table {
    //var $actsAs = array('Containable');
    
    public function initialize(array $config) {
        $this->addBehavior('Timestamp');
        parent::initialize($config);
    }
}