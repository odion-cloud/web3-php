<?php declare(strict_types=1);

namespace Litehex\Web3\Formatters;

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
class TransactionFormatter implements FormatterInterface
{

    /**
     * format
     *
     * @param mixed $value
     * @return array
     */
    public static function format(mixed $value): array
    {
        $value = (array)$value;
        $arguments = func_get_args();
        $transaction = [];

        if (isset($arguments[1]) && is_array($arguments[1])) {
            $transaction = $arguments[1];
        }
        if (isset($value['from'])) {
            $transaction['from'] = AddressFormatter::format($value['from']);
        }
        if (isset($value['to'])) {
            $transaction['to'] = AddressFormatter::format($value['to']);
        }
        if (isset($value['gas'])) {
            $transaction['gas'] = QuantityFormatter::format($value['gas']);
        }
        if (isset($value['gasPrice'])) {
            $transaction['gasPrice'] = QuantityFormatter::format($value['gasPrice']);
        }
        if (isset($value['value'])) {
            $transaction['value'] = QuantityFormatter::format($value['value']);
        }
        if (isset($value['data'])) {
            $transaction['data'] = HexFormatter::format($value['data']);
        }
        if (isset($value['nonce'])) {
            $transaction['nonce'] = IntegerFormatter::format($value['nonce']);
        }
        if (isset($value['chainId'])) {
            $transaction['chainId'] = IntegerFormatter::format($value['chainId']);
        }
        return $transaction;
    }

}