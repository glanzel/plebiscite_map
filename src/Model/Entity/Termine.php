<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Termine Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime|null $beginn
 * @property \Cake\I18n\FrozenTime|null $ende
 * @property int|null $ort
 * @property string|null $typ
 * @property int|null $details
 */
class Termine extends Entity
{
    
}
