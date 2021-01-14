<?php
/**
 * @category     Pugnet
 * @package      Pugnet_PlpRandomCats
 * @subpackage   Model
 * @author       Maciej Powallo <maciej.powallo@gmail.com>
 * @copyright    2021 Pugnet
 * @since        1.0.0
 */
declare(strict_types=1);

namespace Pugnet\PlpRandomCats\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Pugnet\PlpRandomCats\Enum\ConfigEnum;

/**
 * Class ConfigProvider
 *
 * @package Pugnet\PlpRandomCats\Model
 */
class ConfigProvider
{
    protected $pathPrefix = 'pugnet_plprandomcats/';
    protected $scopeConfig;
    protected $storeManager;

    /**
     * ConfigProvider constructor.
     *
     * @param ScopeConfigInterface  $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        $this->scopeConfig  = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * @param        $path
     * @param string $scope
     * @param null   $storeId
     *
     * @return string|null|bool|int
     * @codeCoverageIgnore
     */
    protected function getStoreConfig(
        $path,
        $scope = ScopeInterface::SCOPE_STORE,
        $storeId = null
    ) {
        $store = $this->getStore();

        if ($store instanceof StoreInterface) {
            $storeId = $store->getId();
        }

        if (!$storeId) {
            $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
        }

        return $this->scopeConfig->getValue($this->pathPrefix . $path, $scope, $storeId);
    }

    /**
     * @param $path
     *
     * @return string|null|bool|int
     * @codeCoverageIgnore
     */
    protected function getGlobalConfig($path)
    {
        return $this->scopeConfig->getValue($this->pathPrefix . $path);
    }

    /**
     * @return StoreInterface|null
     * @codeCoverageIgnore
     */
    protected function getStore(): ?StoreInterface
    {
        try {
            $store = $this->storeManager->getStore();
        } catch (\Exception $e) {
            return null;
        }

        return $store;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return (bool)$this->getStoreConfig(ConfigEnum::CONFIG_ENABLED);
    }

    /**
     * @return string|null
     */
    public function getApiKey(): ?string
    {
        return $this->getStoreConfig(ConfigEnum::CONFIG_API_KEY);
    }
}
