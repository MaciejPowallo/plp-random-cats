<?php
/**
 * @category     Pugnet
 * @package      Pugnet_PlpRandomCats
 * @subpackage   Enum
 * @author       Maciej Powallo <maciej.powallo@gmail.com>
 * @copyright    2021 Pugnet
 * @since        1.0.0
 */
declare(strict_types=1);

namespace Pugnet\PlpRandomCats\Enum;

/**
 * Class ApiEnum
 * @package Pugnet\PlpRandomCats\Enum
 */
class ApiEnum
{
    public const REQUEST_TIMEOUT     = 2000;
    public const END_POINT_URL       = 'randomcatapi.orbalab.com/?api_key=%s';
    public const DEFAULT_PLACEHOLDER = 'Pugnet_PlpRandomCats::images/404.jpg';
    public const URL_KEY             = 'url';
}
