<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Point Entity
 *
 * @property string $id
 * @property string|null $Name
 * @property string $Strasse
 * @property string $Nr
 * @property int $PLZ
 * @property string $Stadt
 * @property string|null $Beschreibung
 * @property float|null $Laengengrad
 * @property float|null $Breitengrad
 * @property string|null $Kategorie
 */
class Point extends Entity
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
/* SCHLECHT
    protected $_accessible = [
        'Name' => true,
        'Strasse' => true,
        'Nr' => true,
        'PLZ' => true,
        'Stadt' => true,
        'Beschreibung' => true,
        'Laengengrad' => true,
        'Breitengrad' => true,
        'Kategorie' => true,
    ];
 */
}
