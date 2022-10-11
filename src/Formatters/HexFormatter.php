<?php declare(strict_types=1);

namespace Litehex\Web3\Formatters;

use Litehex\Web3\Utils;

/**
 * This is part of the Litehex Web3 package.
 *
 * @link https://github.com/litehex/web3-php
 * @copyright Copyright (c) 2022 Litehex Ltd.
 *
 * @author Peter Lai <alk03073135@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class HexFormatter implements FormatterInterface
{

    /**
     * format
     *
     * @param mixed $value
     * @return string
     */
    public static function format(mixed $value): string
    {
        $value = Utils::toString($value);
        $value = mb_strtolower($value);

        if (Utils::isZeroPrefixed($value)) {
            return $value;
        }

        return Utils::toHex($value, true);
    }

}