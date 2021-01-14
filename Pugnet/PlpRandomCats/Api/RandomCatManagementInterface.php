<?php
/**
 * @category     Pugnet
 * @package      Pugnet_PlpRandomCats
 * @subpackage   Api
 * @author       Maciej Powallo <maciej.powallo@gmail.com>
 * @copyright    2021 Pugnet
 * @since        1.0.0
 */
declare(strict_types=1);

namespace Pugnet\PlpRandomCats\Api;

/**
 * Interface RandomCatManagementInterface
 * @package Pugnet\PlpRandomCats\Api
 */
interface RandomCatManagementInterface
{
    /**
     * GET image url for Random Cat API
     *
     * @return string
     */
    public function getRandomCatData(): string;
}
