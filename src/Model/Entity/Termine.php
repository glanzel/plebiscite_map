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
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'beginn' => true,
        'ende' => true,
        'ort' => true,
        'typ' => true,
        'details' => true,
    ];
}
