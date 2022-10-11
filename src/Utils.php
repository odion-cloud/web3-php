<?php declare(strict_types=1);

namespace Litehex\Web3;

use InvalidArgumentException;
use kornrunner\Keccak;
use Litehex\Web3\Util\BloomFilters;
use Litehex\Web3\Util\BN;
use Litehex\Web3\Util\Hex;
use phpseclib\Math\BigInteger;
use phpseclib\Math\BigInteger as BigNumber;
use stdClass;

/**
 * The eth module contains methods related to the Ethereum blockchain.
 *
 * This is part of the Litehex Web3 package.
 *
 * @link https://github.com/utilities-php/utilities-php
 * @author Peter Lai <alk03073135@gmail.com>
 * @author Shahrad Elahi <shahrad@litehex.com>
 * @licence MIT
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class Utils
{

    /**
     * Bloom Filters
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#bloom-filters
     */
    use BloomFilters;

    /**
     * Hex Utilities
     */
    use Hex;

    /**
     * BN
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-utils.html#bn
     */
    use BN;

    /**
     * SHA3_NULL_HASH
     *
     * @const string
     */
    const SHA3_NULL_HASH = 'c5d2460186f7233c927e7db2dcc703c0e500b653ca82273b7bfad8045d85a470';

    /**
     * UNITS
     * from ethjs-unit
     *
     * @const array
     */
    const UNITS = [
        'noether' => '0',
        'wei' => '1',
        'kwei' => '1000',
        'Kwei' => '1000',
        'babbage' => '1000',
        'femtoether' => '1000',
        'mwei' => '1000000',
        'Mwei' => '1000000',
        'lovelace' => '1000000',
        'picoether' => '1000000',
        'gwei' => '1000000000',
        'Gwei' => '1000000000',
        'shannon' => '1000000000',
        'nanoether' => '1000000000',
        'nano' => '1000000000',
        'szabo' => '1000000000000',
        'microether' => '1000000000000',
        'micro' => '1000000000000',
        'finney' => '1000000000000000',
        'milliether' => '1000000000000000',
        'milli' => '1000000000000000',
        'ether' => '1000000000000000000',
        'kether' => '1000000000000000000000',
        'grand' => '1000000000000000000000',
        'mether' => '1000000000000000000000000',
        'gether' => '1000000000000000000000000000',
        'tether' => '1000000000000000000000000000000'
    ];

    /**
     * hexToBin
     *
     * @param string
     * @return string
     */
    public static function hexToBin($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('The value to hexToBin function must be string.');
        }
        if (self::isZeroPrefixed($value)) {
            $count = 1;
            $value = str_replace('0x', '', $value, $count);
        }
        return pack('H*', $value);
    }

    /**
     * isZeroPrefixed
     *
     * @param string
     * @return bool
     */
    public static function isZeroPrefixed($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('The value to isZeroPrefixed function must be string.');
        }
        return (strpos($value, '0x') === 0);
    }

    /**
     * stripZero
     *
     * @param string $value
     * @return string
     */
    public static function stripZero($value)
    {
        if (self::isZeroPrefixed($value)) {
            $count = 1;
            return str_replace('0x', '', $value, $count);
        }
        return $value;
    }

    /**
     * isNegative
     *
     * @param string
     * @return bool
     */
    public static function isNegative($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('The value to isNegative function must be string.');
        }
        return (strpos($value, '-') === 0);
    }

    /**
     * isAddress
     *
     * @param string $value
     * @return bool
     */
    public static function isAddress(string $value): bool
    {
        if (preg_match('/^(0x|0X)?[a-f0-9A-F]{40}$/', $value) !== 1) {
            return false;
        } elseif (preg_match('/^(0x|0X)?[a-f0-9]{40}$/', $value) === 1 || preg_match('/^(0x|0X)?[A-F0-9]{40}$/', $value) === 1) {
            return true;
        }
        return self::isChecksumAddress($value);
    }

    /**
     * isChecksumAddress
     *
     * @param string $address e.g. '0x52908400098527886E0F7030069857D2E4169EE7'
     * @return bool
     */
    public static function isChecksumAddress(string $address): bool
    {
        $address = self::stripZero($address);
        $hash = self::stripZero(self::sha3(mb_strtolower($address)));

        for ($i = 0; $i < 40; $i++) {
            if (
                (intval($hash[$i], 16) > 7 && mb_strtoupper($address[$i]) !== $address[$i]) ||
                (intval($hash[$i], 16) <= 7 && mb_strtolower($address[$i]) !== $address[$i])
            ) {
                return false;
            }
        }
        return true;
    }

    /**
     * toChecksumAddress
     *
     * @param string $value
     * @return string
     */
    public static function toChecksumAddress($value)
    {
        if (!is_string($value)) {
            throw new InvalidArgumentException('The value to toChecksumAddress function must be string.');
        }
        $value = self::stripZero(strtolower($value));
        $hash = self::stripZero(self::sha3($value));
        $ret = '0x';

        for ($i = 0; $i < 40; $i++) {
            if (intval($hash[$i], 16) >= 8) {
                $ret .= strtoupper($value[$i]);
            } else {
                $ret .= $value[$i];
            }
        }
        return $ret;
    }

    /**
     * sha3
     * keccak256
     *
     * @param string $value
     *
     * @return string|null
     * @throws \Exception
     */
    public static function sha3(string $value): string|null
    {
        if (str_starts_with($value, '0x')) {
            $value = self::hexToBin($value);
        }

        $hash = Keccak::hash($value, 256);

        if ($hash === self::SHA3_NULL_HASH) {
            return null;
        }

        return '0x' . $hash;
    }

    /**
     * toString
     *
     * @param mixed $value
     * @return string
     */
    public static function toString($value)
    {
        $value = (string)$value;

        return $value;
    }

    /**
     * toWei
     * Change number from unit to wei.
     * For example:
     * $wei = Utils::toWei('1', 'kwei');
     * $wei->toString(); // 1000
     *
     * @param BigNumber|string $number
     * @param string $unit
     * @return string
     */
    public static function toWei(BigNumber|string $number, string $unit): string
    {
        if (!is_string($number) && !($number instanceof BigNumber)) {
            throw new InvalidArgumentException('toWei number must be String or BigNumber.');
        }

        $bn = self::toBn($number);
        $unit = mb_strtolower($unit);

        if (!isset(self::UNITS[$unit])) {
            throw new InvalidArgumentException('toWei doesn\'t support ' . $unit . ' unit.');
        }

        $bnt = new BigNumber(self::UNITS[$unit]);

        if (is_array($bn)) {
            // fraction number
            list($whole, $fraction, $fractionLength, $negative1) = $bn;

            if ($fractionLength > strlen(self::UNITS[$unit])) {
                throw new InvalidArgumentException('toWei fraction part is out of limit.');
            }
            $whole = $whole->multiply($bnt);

            // There is no pow function in phpseclib 2.0, only can see in dev-master
            // Maybe implement own biginteger in the future
            // See 2.0 BigInteger: https://github.com/phpseclib/phpseclib/blob/2.0/phpseclib/Math/BigInteger.php
            // See dev-master BigInteger: https://github.com/phpseclib/phpseclib/blob/master/phpseclib/Math/BigInteger.php#L700
            // $base = (new BigNumber(10))->pow(new BigNumber($fractionLength));

            // So we switch phpseclib special global param, change in the future
            switch (MATH_BIGINTEGER_MODE) {
                case $whole::MODE_GMP:
                    static $two;
                    $powerBase = gmp_pow(gmp_init(10), (int)$fractionLength);
                    break;
                case $whole::MODE_BCMATH:
                    $powerBase = bcpow('10', (string)$fractionLength, 0);
                    break;
                default:
                    $powerBase = pow(10, (int)$fractionLength);
                    break;
            }
            $base = new BigNumber($powerBase);
            $fraction = $fraction->multiply($bnt)->divide($base)[0];

            if ($negative1 !== false) {
                return $whole->add($fraction)->multiply($negative1)->toHex();
            }
            return $whole->add($fraction)->toHex();
        }

        return $bn->multiply($bnt)->toHex();
    }

    /**
     * toEther
     * Change number from unit to ether.
     * For example:
     * list($bnq, $bnr) = Utils::toEther('1', 'kether');
     * $bnq->toString(); // 1000
     *
     * @param BigNumber|string|int $number
     * @param string $unit
     * @return array
     */
    public static function toEther($number, $unit)
    {
        // if ($unit === 'ether') {
        //     throw new InvalidArgumentException('Please use another unit.');
        // }
        $wei = self::toWei($number, $unit);
        $bnt = new BigNumber(self::UNITS['ether']);

        return $wei->divide($bnt);
    }

    /**
     * fromWei
     * Change number from wei to unit.
     * For example:
     * list($bnq, $bnr) = Utils::fromWei('1000', 'kwei');
     * $bnq->toString(); // 1
     *
     * @param BigNumber|string|int $number
     * @param string $unit
     * @return BigNumber
     */
    public static function fromWei($number, $unit)
    {
        $bn = self::toBn($number);

        if (!is_string($unit)) {
            throw new InvalidArgumentException('fromWei unit must be string.');
        }
        if (!isset(self::UNITS[$unit])) {
            throw new InvalidArgumentException('fromWei doesn\'t support ' . $unit . ' unit.');
        }
        $bnt = new BigNumber(self::UNITS[$unit]);

        return $bn->divide($bnt);
    }

    /**
     * jsonMethodToString
     *
     * @param stdClass|array $json
     * @return string
     */
    public static function jsonMethodToString($json)
    {
        if ($json instanceof stdClass) {
            // one way to change whole json stdClass to array type
            // $jsonString = json_encode($json);

            // if (JSON_ERROR_NONE !== json_last_error()) {
            //     throw new InvalidArgumentException('json_decode error: ' . json_last_error_msg());
            // }
            // $json = json_decode($jsonString, true);

            // another way to change whole json to array type but need the depth
            // $json = self::jsonToArray($json, $depth)

            // another way to change json to array type but not whole json stdClass
            $json = (array)$json;
            $typeName = [];

            foreach ($json['inputs'] as $param) {
                if (isset($param->type)) {
                    $typeName[] = $param->type;
                }
            }
            return $json['name'] . '(' . implode(',', $typeName) . ')';
        } elseif (!is_array($json)) {
            throw new InvalidArgumentException('jsonMethodToString json must be array or stdClass.');
        }
        if (isset($json['name']) && strpos($json['name'], '(') > 0) {
            return $json['name'];
        }
        $typeName = [];

        foreach ($json['inputs'] as $param) {
            if (isset($param['type'])) {
                $typeName[] = $param['type'];
            }
        }
        return $json['name'] . '(' . implode(',', $typeName) . ')';
    }

    /**
     * jsonToArray
     *
     * @param stdClass|array $json
     * @return array
     */
    public static function jsonToArray($json)
    {
        if ($json instanceof stdClass) {
            $json = (array)$json;
            $typeName = [];

            foreach ($json as $key => $param) {
                if (is_array($param)) {
                    foreach ($param as $subKey => $subParam) {
                        $json[$key][$subKey] = self::jsonToArray($subParam);
                    }
                } elseif ($param instanceof stdClass) {
                    $json[$key] = self::jsonToArray($param);
                }
            }
        } elseif (is_array($json)) {
            foreach ($json as $key => $param) {
                if (is_array($param)) {
                    foreach ($param as $subKey => $subParam) {
                        $json[$key][$subKey] = self::jsonToArray($subParam);
                    }
                } elseif ($param instanceof stdClass) {
                    $json[$key] = self::jsonToArray($param);
                }
            }
        }
        return $json;
    }

    /**
     * toBn
     * Change number or number string to bignumber.
     *
     * @param BigNumber|string|int $number
     * @return array|BigNumber
     */
    public static function toBn(BigNumber|string|int $number): array|BigNumber
    {
        if ($number instanceof BigNumber) {
            $bn = $number;
        } elseif (is_int($number)) {
            $bn = new BigNumber($number);
        } elseif (is_numeric($number)) {
            $number = (string)$number;

            if (self::isNegative($number)) {
                $count = 1;
                $number = str_replace('-', '', $number, $count);
                $negative1 = new BigNumber(-1);
            }
            if (strpos($number, '.') > 0) {
                $comps = explode('.', $number);

                if (count($comps) > 2) {
                    throw new InvalidArgumentException('toBn number must be a valid number.');
                }
                $whole = $comps[0];
                $fraction = $comps[1];

                return [
                    new BigNumber($whole),
                    new BigNumber($fraction),
                    strlen($comps[1]),
                        $negative1 ?? false
                ];
            } else {
                $bn = new BigNumber($number);
            }
            if (isset($negative1)) {
                $bn = $bn->multiply($negative1);
            }
        } elseif (is_string($number)) {
            $number = mb_strtolower($number);

            if (self::isNegative($number)) {
                $count = 1;
                $number = str_replace('-', '', $number, $count);
                $negative1 = new BigNumber(-1);
            }
            if (self::isZeroPrefixed($number) || preg_match('/^[0-9a-f]+$/i', $number) === 1) {
                $number = self::stripZero($number);
                $bn = new BigNumber($number, 16);
            } elseif (empty($number)) {
                $bn = new BigNumber(0);
            } else {
                throw new InvalidArgumentException('toBn number must be valid hex string.');
            }
            if (isset($negative1)) {
                $bn = $bn->multiply($negative1);
            }
        } else {
            throw new InvalidArgumentException('toBn number must be BigNumber, string or int.');
        }
        return $bn;
    }

    /**
     * toBloom
     *
     * @param string $address
     * @return string
     */
    public static function toBloom(string $address): string
    {
        $address = self::stripZero($address);
        $address = self::stripHexPrefix($address);
        $address = str_pad($address, 64, '0', STR_PAD_LEFT);
        $address = self::hexToBin($address);
        $address = self::keccak256($address);
        $address = self::stripHexPrefix($address);
        return str_pad($address, 256, '0', STR_PAD_LEFT);
    }

    /**
     * stripHexPrefix
     *
     * @param string $hex
     * @return string
     */
    public static function stripHexPrefix(string $hex): string
    {
        if (self::isHexPrefixed($hex)) {
            return substr($hex, 2);
        }
        return $hex;
    }

    /**
     * isHexPrefixed
     *
     * @param string $hex
     * @return bool
     */
    public static function isHexPrefixed(string $hex): bool
    {
        return str_starts_with($hex, '0x');
    }

    /**
     * keccak256
     *
     * @param string $data
     * @return string
     */
    public static function keccak256(string $data): string
    {
        return hash('sha3-256', $data);
    }

    /**
     * Adding padding to string on the left
     *
     * @param string $value The value
     * @param int $chars The number of characters
     * @return string
     */
    public static function padLeft(string $value, int $chars): string
    {
        $hasPrefix = str_starts_with($value, '0x') || is_numeric($value);
        $value = preg_replace('/^0x/i', '', $value);

        $padding = max($chars - strlen($value) + 1, 0);

        return ($hasPrefix ? '0x' : '') . str_repeat('0', $padding) . $value;
    }

}