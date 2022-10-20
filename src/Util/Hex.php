<?php declare(strict_types=1);

namespace Litehex\Web3\Util;

use phpseclib\Math\BigInteger as BigNumber;

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
trait Hex
{

    /**
     * randomHex
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#randomhex
     *
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public static function randomHex(int $length = 32): string
    {
        return '0x' . bin2hex(random_bytes($length));
    }

    /**
     * isHex
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#ishex
     *
     * @param string|BigNumber|int $hex
     * @return bool
     */
    public static function isHex(string|BigNumber|int $hex): bool
    {
        if (is_string($hex)) {
            return preg_match('/^(0x)?[0-9a-fA-F]*$/', $hex) === 1;
        }

        return false;
    }

    /**
     * isHexStrict
     *
     * Checks if a given string is a HEX string. Difference to isHex is that it
     * requires the string to be prefixed with "0x".
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#ishexstrict
     *
     * @param string|BigNumber|int $hex
     * @return bool
     */
    public static function isHexStrict(string|BigNumber|int $hex): bool
    {
        if (!self::isHex($hex)) {
            return false;
        }

        return preg_match('/^0x[0-9a-fA-F]*$/', $hex) === 1;
    }

    /**
     * toHex
     * Encoding string or integer or numeric string(is not zero prefixed) or big number to hex.
     *
     * @param string|int|BigNumber $value
     * @param bool $isPrefix (default: true)
     * @return string
     */
    public static function toHex(string|int|BigNumber $value, bool $isPrefix = true): string
    {
        if (is_numeric($value)) {
            // turn to hex number
            $bn = self::toBn($value);
            $hex = $bn->toHex(true);
            $hex = preg_replace('/^0+(?!$)/', '', $hex);
        } elseif (is_string($value)) {
            $value = self::stripZero($value);
            $hex = implode('', unpack('H*', $value));
        } elseif ($value instanceof BigNumber) {
            $hex = $value->toHex(true);
            $hex = preg_replace('/^0+(?!$)/', '', $hex);
        } else {
            throw new \InvalidArgumentException(sprintf(
                'Invalid value type "%s" for toHex',
                gettype($value)
            ));
        }
        $hex = $hex == '' ? '0' : $hex;
        if ($isPrefix) {
            return '0x' . $hex;
        }
        return $hex;
    }

    /**
     * hexToNumberString (alias of toBn)
     *
     * Example: hexToNumberString('0xea') => '234'
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#hextonumberstring
     *
     * @param string $hex
     * @return string
     */
    public static function hexToNumberString(string $hex): string
    {
        if (!self::isHex($hex)) {
            throw new \InvalidArgumentException(sprintf(
                'Given value "%s" is not a valid hex string.',
                $hex
            ));
        }

        return self::toBn($hex)->toString();
    }

    /**
     * hexToNumber (alias of toBn)
     *
     * Returns the number representation of a given HEX value.
     *
     * Example: hexToNumber('0xea') => 234
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#hextonumber
     *
     * @param string $hex
     * @return BigNumber
     */
    public static function hexToNumber(string $hex): BigNumber
    {
        if (!self::isHex($hex)) {
            throw new \InvalidArgumentException(sprintf(
                'Given value "%s" is not a valid hex string.',
                $hex
            ));
        }

        return self::toBn($hex);
    }

    /**
     * numberToHex
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#numbertohex
     *
     * @param string|int|BigNumber $value
     * @return string
     */
    public static function numberToHex(string|int|BigNumber $value): string
    {
        return self::toHex($value, true);
    }

    /**
     * hexToUtf8
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#hextoutf8
     *
     * @param string $hex
     * @return string
     */
    public static function hexToUtf8(string $hex): string
    {
        if (!self::isHexStrict($hex)) {
            throw new \InvalidArgumentException(sprintf(
                'Given value "%s" is not a valid hex string.',
                $hex
            ));
        }

        $hex = self::stripZero($hex);
        $str = '';
        for ($i = 0; $i < strlen($hex) - 1; $i += 2) {
            $str .= chr(hexdec($hex[$i] . $hex[$i + 1]));
        }
        return $str;
    }

    /**
     * hexToAscii (alias of hexToUtf8)
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#hextoascii
     *
     * @param string $hex
     * @return string
     */
    public static function hexToAscii(string $hex): string
    {
        return self::hexToUtf8($hex);
    }

    /**
     * utf8ToHex
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#utf8tohex
     *
     * @param string $str
     * @return string
     */
    public static function utf8ToHex(string $str): string
    {
        $hex = '';
        for ($i = 0; $i < strlen($str); $i++) {
            $hex .= dechex(ord($str[$i]));
        }
        return '0x' . $hex;
    }

    /**
     * asciiToHex (alias of utf8ToHex)
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#asctohex
     *
     * @param string $str
     * @return string
     */
    public static function asciiToHex(string $str): string
    {
        return self::utf8ToHex($str);
    }

    /**
     * hexToBytes
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#hextobytes
     *
     * @param string $hex
     * @return array Returns a byte array from the given HEX string.
     */
    public static function hexToBytes(string $hex): array
    {
        if (!self::isHexStrict($hex)) {
            throw new \InvalidArgumentException(sprintf(
                'Given value "%s" is not a valid hex string.',
                $hex
            ));
        }

        $hex = self::stripZero($hex);
        $bytes = [];
        for ($c = 0; $c < strlen($hex); $c += 2) {
            $bytes[] = hexdec($hex[$c] . $hex[$c + 1]);
        }
        return $bytes;
    }

    /**
     * bytesToHex
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#bytestohex
     *
     * @param array $bytes
     * @return string Returns a HEX string from the given byte array.
     */
    public static function bytesToHex(array $bytes): string
    {
        $hex = '';
        foreach ($bytes as $byte) {
            $hex .= str_pad(dechex($byte), 2, '0', STR_PAD_LEFT);
        }
        return '0x' . $hex;
    }

}