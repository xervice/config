<?php

namespace XerviceTest;

use Codeception\Example;
use Xervice\Config\XerviceConfig;
use Xervice\Config\XerviceConfigFactory;

class IntegrationTest extends \Codeception\Test\Unit
{
    /**
     * @var \XerviceTest\XerviceTester
     */
    protected $tester;

    /**
     * @var \Xervice\Config\Container\ConfigContainer
     */
    private $configData;

    protected function _before()
    {
        $this->loadConfig();
    }


    /**
     * @group Xervice
     * @group Config
     * @group XerviceConfig
     *
     * @dataProvider getConfigTestData
     */
    public function testConfig($name, $value)
    {
        $this->assertEquals(
            $value,
            $this->configData->get($name)
        );
    }

    public function testDefaultConfig()
    {
        $this->assertEquals(
            'defaultval',
            $this->configData->get('NOT_EXISTING_KEY', 'defaultval')
        );
    }

    public function testConfigPath()
    {
        putenv('APPLICATION_PATH=');
        putenv('CONFIG_PATH=' . __DIR__ . '/TestConfig/config');
        $this->loadConfig();

        $this->assertEquals(
            'testDir',
            $this->configData->get('customTestDir')
        );
    }

    public function testApplicationPath()
    {
        putenv('APPLICATION_PATH=' . __DIR__ . '/TestConfig');
        putenv('CONFIG_PATH=');
        $this->loadConfig();

        $this->assertEquals(
            'testDir',
            $this->configData->get('customTestDir')
        );
    }

    /**
     * @return array
     */
    public function getConfigTestData(): array
    {
        return [
            [
                'default',
                'testDefault'
            ],
            [
                'production',
                'prod_test'
            ],
            [
                'local',
                'local-test'
            ],
            [
                'prod_overwrite',
                'local'
            ],
            [
                'default_overwrite',
                'testProduction'
            ]
        ];
    }

    private function loadConfig(): void
    {
        $config = new XerviceConfig(new XerviceConfigFactory());
        $this->configData = $config->getConfig();
    }
}