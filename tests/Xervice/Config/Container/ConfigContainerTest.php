<?php
namespace XerviceTest\Config\Container;

use Xervice\Config\Container\ConfigContainer;

class ConfigContainerTest extends \Codeception\Test\Unit
{
    /**
     * @var \XerviceTest\XerviceTester
     */
    protected $tester;

    /**
     * @group Xervice
     * @group Config
     * @group ConfigContainer
     * @group Integration
     */
    public function testGetAndSet()
    {
        $configContainer = new ConfigContainer();
        $configContainer->set('test', 'testing');
        $this->assertEquals(
            'testing',
            $configContainer->get('test')
        );
    }

    /**
     * @group Xervice
     * @group Config
     * @group ConfigContainer
     * @group Integration
     */
    public function testGetWithDefault()
    {
        $configContainer = new ConfigContainer();
        $this->assertEquals(
            'testtest',
            $configContainer->get('notexist', 'testtest')
        );
    }
}