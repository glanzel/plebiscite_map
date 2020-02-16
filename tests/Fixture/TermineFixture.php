<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TermineFixture
 */
class TermineFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'termine';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'beginn' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'ende' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        'ort' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'typ' => ['type' => 'string', 'length' => 40, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'details' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'Termine_Ort_fk' => ['type' => 'index', 'columns' => ['ort'], 'length' => []],
            'Termine_TerminDetails_fk' => ['type' => 'index', 'columns' => ['details'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'Termine_Ort_fk' => ['type' => 'foreign', 'columns' => ['ort'], 'references' => ['stammorte', 'id'], 'update' => 'cascade', 'delete' => 'restrict', 'length' => []],
            'Termine_TerminDetails_fk' => ['type' => 'foreign', 'columns' => ['details'], 'references' => ['termindetails', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'beginn' => '2020-02-16 14:01:21',
                'ende' => '2020-02-16 14:01:21',
                'ort' => 1,
                'typ' => 'Lorem ipsum dolor sit amet',
                'details' => 1,
            ],
        ];
        parent::init();
    }
}
