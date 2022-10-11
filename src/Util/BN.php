<?php declare(strict_types=1);

namespace Litehex\Web3\Util;

use phpseclib\Math\BigInteger;

/**
 * This is part of the Litehex Web3 package.
 *
 * @link https://github.com/litehex/web3-php
 * @copyright Copyright (c) 2022 Litehex Ltd.
 *
 * @author Shahrad Elahi <shahrad@litehex.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
trait BN
{

    /**
     * BN
     *
     * @param string|BigInteger $number
     * @return BigInteger
     */
    public static function BN(string $number): BigInteger
    {
        return \Litehex\Web3\Utils::toBN($number);
    }

    /**
     * toBN
     *
     * @param string|BigInteger $number
     * @return BigInteger
     */
    public static function toBN(string $number): BigInteger
    {
        return new BigInteger($number);
    }

}