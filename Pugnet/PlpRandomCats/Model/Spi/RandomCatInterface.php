<?php
/**
 * @category     Pugnet
 * @package      Pugnet_PlpRandomCats
 * @subpackage   Model
 * @author       Maciej Powallo <maciej.powallo@gmail.com>
 * @copyright    2021 Pugnet
 * @since        1.0.0
 */

namespace Pugnet\PlpRandomCats\Model\Spi;

/**
 * Interface RandomCatInterface
 *
 * @package Pugnet\PlpRandomCats\Model\Spi
 */
interface RandomCatInterface
{
    /**
     * @return string
     */
    public function getCatUrl(): string;
}
