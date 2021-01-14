<?php
/**
 * @category     Pugnet
 * @package      Pugnet_PlpRandomCats
 * @subpackage   Plugin
 * @author       Maciej Powallo <maciej.powallo@gmail.com>
 * @copyright    2021 Pugnet
 * @since        1.0.0
 */
declare(strict_types=1);

namespace Pugnet\PlpRandomCats\Plugin\Block\Product;

use Pugnet\PlpRandomCats\Model\ConfigProvider;
use Magento\Catalog\Block\Product\Image as MagentoImage;
use Pugnet\PlpRandomCats\Model\RandomCat;

/**
 * Class Image
 *
 * @package Pugnet\PlpRandomCats\Plugin\Block\Product
 */
class Image
{
    protected $configProvider;
    protected $randomCat;

    /**
     * Image constructor.
     *
     * @param ConfigProvider $configProvider
     * @param RandomCat      $randomCat
     */
    public function __construct(
        ConfigProvider $configProvider,
        RandomCat $randomCat
    ) {
        $this->configProvider = $configProvider;
        $this->randomCat = $randomCat;
    }

    /**
     * @param MagentoImage $subject
     * @return MagentoImage
     */
    public function beforeToHtml(MagentoImage $subject): MagentoImage
    {
        if ($this->configProvider->isEnabled()) {
            $subject->setImageUrl($this->randomCat->getCatUrl());
        }

        return $subject;
    }
}
