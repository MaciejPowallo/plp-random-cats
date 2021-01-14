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

use Magento\Framework\HTTP\Client\CurlFactory;
use Magento\Framework\Serialize\Serializer\Json;
use Pugnet\PlpRandomCats\Api\RandomCatManagementInterface;
use Pugnet\PlpRandomCats\Enum\ApiEnum;

/**
 * Class RandomCatManagement
 * @package Pugnet\PlpRandomCats\Model
 */
class RandomCatManagement implements RandomCatManagementInterface
{
    protected $jsonSerializer;
    protected $configProvider;
    protected $curlFactory;

    /**
     * RandomCatManagement constructor.
     * @param Json           $jsonSerializer
     * @param CurlFactory    $curlFactory
     * @param ConfigProvider $configProvider
     */
    public function __construct(
        Json $jsonSerializer,
        CurlFactory $curlFactory,
        ConfigProvider $configProvider
    ) {
        $this->jsonSerializer = $jsonSerializer;
        $this->curlFactory    = $curlFactory;
        $this->configProvider = $configProvider;
    }

    /**
     * @return string
     */
    public function getRandomCatData(): string
    {
        return $this->getResponse();
    }

    /**
     * @return string
     */
    private function getResponse(): string
    {
        $client = $this->curlFactory->create();
        $client->setTimeout(ApiEnum::REQUEST_TIMEOUT);

        $client->get(sprintf(ApiEnum::END_POINT_URL,
            $this->configProvider->getApiKey()
        ));

        return $client->getBody();
    }
}
