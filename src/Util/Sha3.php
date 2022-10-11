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
trait Sha3
{

    /**
     * sha3
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#sha3
     *
     * @param string|BigInteger|float|int $value
     * @param array $options
     * @return string
     */
    public static function sha3(string|BigInteger|float|int $value, array $options = []): string
    {
        $options = array_merge([
            'encoding' => 'hex',
        ], $options);

        if ($options['encoding'] === 'hex') {
            $value = Hex::toHex($value);
        }

        return self::sha3Raw($value);
    }

    /**
     * sha3Raw
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#sha3raw
     *
     * @param string $value
     * @return string
     */
    public static function sha3Raw(string $value): string
    {
        return '0x' . hash('sha3-256', $value);
    }

}