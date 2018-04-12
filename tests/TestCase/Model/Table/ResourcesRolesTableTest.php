<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ResourcesRolesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ResourcesRolesTable Test Case
 */
class ResourcesRolesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ResourcesRolesTable
     */
    public $ResourcesRoles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.resources_roles',
        'app.resources',
        'app.roles',
        'app.users',
        'app.users_roles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ResourcesRoles') ? [] : ['className' => ResourcesRolesTable::class];
        $this->ResourcesRoles = TableRegistry::get('ResourcesRoles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ResourcesRoles);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
