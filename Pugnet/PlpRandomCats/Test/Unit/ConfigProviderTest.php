<?php
/**
 * @category     Pugnet
 * @package      Pugnet_PlpRandomCats
 * @subpackage   Test
 * @author       Maciej Powallo <maciej.powallo@gmail.com>
 * @copyright    2021 Pugnet
 * @since        1.0.0
 */

use Pugnet\PlpRandomCats\Model\ConfigProvider;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class ConfigProviderTest
 */
class ConfigProviderTest extends TestCase
{
    protected const METHOD_GET_VALUE     = 'getValue';
    protected const TEXT_DEFAULT_VALUE   = 'test';

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $scopeConfigMock;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeManagerMock;
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeMock;
    /**
     * @var ConfigProvider
     */
    protected $model;

    /**
     * Set mock values
     */
    protected function setUp()
    {
        $this->scopeConfigMock  = $this->createMock(ScopeConfigInterface::class);
        $this->storeManagerMock = $this->createMock(StoreManagerInterface::class);
        $this->storeMock        = $this->createMock(Store::class);

        $this->storeManagerMock->method('getStore')->will($this->returnValue($this->storeMock));

        $this->model = new ConfigProvider($this->scopeConfigMock, $this->storeManagerMock);
    }

    /**
     * The test checks object instance
     */
    public function testConfigProviderInstance()
    {
        $this->assertInstanceOf(ConfigProvider::class, $this->model);
    }

    /**
     * The test checks the type of returned data. The expected type is boolean
     */
    public function testIsEnabled()
    {
        $this->scopeConfigMock
            ->method(self::METHOD_GET_VALUE)
            ->willReturn(true, false);

        $this->assertTrue($this->model->isEnabled());
        $this->assertNotTrue($this->model->isEnabled());
    }

    /**
     * The test checks the type of returned data. The expected types are string or null
     */
    public function testGetApiKey()
    {
        $this->scopeConfigMock
            ->method(self::METHOD_GET_VALUE)
            ->willReturn(null, self::TEXT_DEFAULT_VALUE);

        $this->assertNull($this->model->getClass());
        $this->assertSame(self::TEXT_DEFAULT_VALUE, $this->model->getApiKey());
    }
}
