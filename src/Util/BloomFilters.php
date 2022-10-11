<?php declare(strict_types=1);

namespace Litehex\Web3\Util;

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
trait BloomFilters
{

    /**
     * isBloom
     *
     * @param string $bloom
     * @return bool
     */
    public static function isBloom(string $bloom): bool
    {
        if (preg_match('/^(0x)?[0-9a-fA-F]{512}$/', $bloom) === 1) {
            return true;
        }

        return false;
    }

    /**
     * Code points to int
     *
     * @param string $codePoint
     * @return int
     */
    private static function codePointToInt(string $codePoint): int
    {
        if (ord($codePoint) >= 48 && ord($codePoint) <= 57) {
            /* ['0'..'9'] -> [0..9] */
            return ord($codePoint) - 48;
        }

        if (ord($codePoint) >= 65 && ord($codePoint) <= 70) {
            /* ['A'..'F'] -> [10..15] */
            return ord($codePoint) - 55;
        }

        if (ord($codePoint) >= 97 && ord($codePoint) <= 102) {
            /* ['a'..'f'] -> [10..15] */
            return ord($codePoint) - 87;
        }

        throw new \RuntimeException('invalid bloom');
    }

    /**
     * isUserEthereumAddressInBloom
     *
     * @param string $address
     * @param string $bloom
     * @return bool
     */
    public static function isUserEthereumAddressInBloom(string $address, string $bloom): bool
    {
        if (!self::isBloom($bloom)) {
            throw new \RuntimeException('Invalid bloom given');
        }

        if (!self::isAddress($address)) {
            throw new \RuntimeException('Invalid ethereum address given');
        }

        // you have to pad the ethereum address to 32 bytes
        // else the bloom filter does not work
        // this is only if your matching the USERS
        // ethereum address. Contract address do not need this
        // hence why we have 2 methods
        // (0x is not in the 2nd parameter of padleft so 64 chars is fine)
        $address = self::padLeft($address, 64);

        return self::isInBloom($bloom, $address);
    }

    /**
     * isContractAddressInBloom
     *
     * @param string $address contractAddress the contract address to test
     * @param string $bloom encoded bloom
     * @return bool Returns true if the contract address is part of the given bloom.
     */
    public static function isContractAddressInBloom(string $address, string $bloom): bool
    {
        if (!self::isBloom($bloom)) {
            throw new \RuntimeException('Invalid bloom given');
        }

        if (!self::isAddress($address)) {
            throw new \RuntimeException('Invalid ethereum address given');
        }

        return self::isInBloom($bloom, $address);
    }

    /**
     * isTopic
     *
     * @param string $topic encoded hex topic
     * @return bool
     */
    public static function isTopic(string $topic): bool
    {
        if (preg_match('/^(0x)?[0-9a-fA-F]{64}$/', $topic) === 1) {
            return true;
        }

        return false;
    }

    /**
     * isTopicInBloom
     *
     * @param string $topic
     * @param string $bloom
     * @return bool Returns true if the topic is part of the given bloom. NOTE: false positives are possible.
     */
    public static function isTopicInBloom(string $topic, string $bloom): bool
    {
        if (!self::isBloom($bloom)) {
            throw new \RuntimeException('Invalid bloom given');
        }

        if (!self::isTopic($topic)) {
            throw new \RuntimeException('Invalid topic given');
        }

        return self::isInBloom($bloom, $topic);
    }

    /**
     * isInBloom
     *
     * @param string $bloom encoded bloom
     * @param string $value The value
     * @return bool
     */
    public static function isInBloom(string $bloom, string $value): bool
    {
        if (strlen($value) !== 64) {
            throw new \RuntimeException('Invalid value given');
        }

        $hash = self::keccak256($value);

        for ($i = 0; $i < 12; $i += 4) {
            $bitpos = ((self::codePointToInt($hash[$i]) << 8) + self::codePointToInt($hash[$i + 1])) & 2047;
            $code = self::codePointToInt($bloom[63 - floor($bitpos / 4)]);
            $offset = 1 << $bitpos % 4;

            if (($code & $offset) !== $offset) {
                return false;
            }
        }

        return true;
    }

}