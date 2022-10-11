<?php declare(strict_types=1);

namespace Litehex\Web3\Formatters;

use Litehex\Web3\Utils;
use phpseclib\Math\BigInteger;

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
class BigNumberFormatter implements FormatterInterface
{

    /**
     * format
     *
     * @param mixed $value
     * @return BigInteger
     */
    public static function format(mixed $value): BigInteger
    {
        $value = Utils::toString($value);
        return Utils::toBn($value);
    }

}