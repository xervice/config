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
        $config = new XerviceConfig(new XerviceConfigFactory());
        $this->configData = $config->getConfig();
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

    public function getConfigTestData()
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
}