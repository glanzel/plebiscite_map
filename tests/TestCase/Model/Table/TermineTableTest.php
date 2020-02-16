<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TermineTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TermineTable Test Case
 */
class TermineTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TermineTable
     */
    public $Termine;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Termine',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Termine') ? [] : ['className' => TermineTable::class];
        $this->Termine = TableRegistry::getTableLocator()->get('Termine', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Termine);

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
