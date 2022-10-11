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
class IntegerFormatter implements FormatterInterface
{

    /**
     * format
     *
     * @param mixed $value
     * @param int $length
     * @return string
     */
    public static function format(mixed $value, int $length = 64): string
    {
        $value = (string)$value;
        $arguments = func_get_args();
        $digit = 64;

        if (isset($arguments[1]) && is_numeric($arguments[1])) {
            $digit = intval($arguments[1]);
        }
        $bn = Utils::toBn($value);
        $bnHex = $bn->toHex(true);
        $padded = mb_substr($bnHex, 0, 1);

        if ($padded !== 'f') {
            $padded = '0';
        }
        return implode('', array_fill(0, $digit - mb_strlen($bnHex), $padded)) . $bnHex;
    }

}