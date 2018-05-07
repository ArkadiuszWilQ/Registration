<?php
namespace App\Test\TestCase\Controller\Component;

use App\Controller\Component\XmlParserComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Component\XmlParserComponent Test Case
 */
class XmlParserComponentTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Controller\Component\XmlParserComponent
     */
    public $XmlParser;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->XmlParser = new XmlParserComponent($registry);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->XmlParser);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
