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

use Exception;
use Magento\Backend\Helper\Data;
use Magento\Cms\Helper\Wysiwyg\Images;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\Escaper;
use Magento\Framework\Filesystem;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Asset\Repository;
use Magento\Store\Model\StoreManagerInterface;
use Pugnet\PlpRandomCats\Api\RandomCatManagementInterface;
use Pugnet\PlpRandomCats\Enum\ApiEnum;
use Magento\Framework\Filesystem\Io\File;
use Psr\Log\LoggerInterface;
use Pugnet\PlpRandomCats\Model\Spi\RandomCatInterface;

/**
 * Class RandomCat
 * @package Pugnet\PlpRandomCats\Model
 */
class RandomCat extends Images implements RandomCatInterface
{
    protected $assetRepository;
    protected $jsonSerializer;
    protected $logger;
    protected $fileDriver;
    protected $catManagement;

    /**
     * RandomCat constructor.
     * @param Context                      $context
     * @param Data                         $backendData
     * @param Filesystem                   $filesystem
     * @param StoreManagerInterface        $storeManager
     * @param Escaper                      $escaper
     * @param Repository                   $assetRepository
     * @param Json                         $jsonSerializer
     * @param LoggerInterface              $logger
     * @param RandomCatManagementInterface $catManagement
     * @param File                         $fileDriver
     */
    public function __construct(
        Context $context,
        Data $backendData,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager,
        Escaper $escaper,
        Repository $assetRepository,
        Json $jsonSerializer,
        LoggerInterface $logger,
        RandomCatManagementInterface $catManagement,
        File $fileDriver
    ) {
        parent::__construct($context, $backendData, $filesystem, $storeManager, $escaper);
        $this->assetRepository = $assetRepository;
        $this->jsonSerializer  = $jsonSerializer;
        $this->fileDriver      = $fileDriver;
        $this->logger          = $logger;
        $this->catManagement   = $catManagement;
    }

    /**
     * @return string
     */
    public function getCatUrl(): string
    {
        try {
            $urlData = $this->jsonSerializer->unserialize($this->catManagement->getRandomCatData());
        } catch (Exception $e) {
            $this->logger->notice('Error during downloading random cat image');

            return $this->getDefaultCatUrl();
        }

        if (is_array($urlData) && isset($urlData[ApiEnum::URL_KEY])) {

            return $this->checkIfFileExist($urlData[ApiEnum::URL_KEY])
                ? $urlData[ApiEnum::URL_KEY]
                : $this->getDefaultCatUrl();
        }

        return $this->getDefaultCatUrl();
    }

    /**
     * @return string
     */
    protected function getDefaultCatUrl(): string
    {
        $params = ['_secure' => $this->_getRequest()->isSecure()];

        return $this->assetRepository->getUrlWithParams(ApiEnum::DEFAULT_PLACEHOLDER, $params);
    }

    /**
     * @param string $url
     * @return bool
     */
    protected function checkIfFileExist(string $url): bool
    {
        $result = $this->fileDriver->read($url);

        if (!$result) {
            $this->logger->notice(sprintf('The image on %s path does not exist', $url));
        }

        return (bool)$result;
    }
}
