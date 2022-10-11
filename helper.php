<?php declare(strict_types=1);

use Litehex\Web3\Providers\Provider;
use Litehex\Web3\Utils;
use phpseclib\Math\BigInteger as BigNumber;

if (!function_exists('web3_provider')) {
    /**
     * Get the web3 provider.
     *
     * @param string $provider_rpc The provider rpc url.
     * @param array $config [optional] <p>
     * @return Provider
     */
    function web3_provider(string $provider_rpc, array $config = []): Provider
    {
        return new Provider($provider_rpc, $config);
    }
}

if (!function_exists('number_to_hex')) {
    /**
     * Convert a number to hex.
     *
     * @param BigNumber|string|float|int $number The number to convert.
     * @return string
     */
    function number_to_hex(BigNumber|string|float|int $number): string
    {
        return Utils::numberToHex($number);
    }
}

if (!function_exists('hex_decode')) {
    /**
     * Convert a hex string to a number.
     *
     * @param string $hex The hex string to convert.
     * @return string
     */
    function hex_decode(string $hex): string
    {
        return Utils::hexToAscii($hex);
    }
}

if (!function_exists('hex_encode')) {
    /**
     * Convert a string to a hex string.
     *
     * @param string $string The string to convert.
     * @return string
     */
    function hex_encode(string $string): string
    {
        return Utils::asciiToHex($string);
    }
}