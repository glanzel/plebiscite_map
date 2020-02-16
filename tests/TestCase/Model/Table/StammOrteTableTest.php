<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StammOrteTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StammOrteTable Test Case
 */
class StammOrteTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\StammOrteTable
     */
    public $StammOrte;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.StammOrte',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('StammOrte') ? [] : ['className' => StammOrteTable::class];
        $this->StammOrte = TableRegistry::getTableLocator()->get('StammOrte', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->StammOrte);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
