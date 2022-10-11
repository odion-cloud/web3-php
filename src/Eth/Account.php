<?php declare(strict_types=1);

namespace Litehex\Web3\Eth;

use JetBrains\PhpStorm\ArrayShape;
use Litehex\Web3\Contracts\KeyPair;
use Litehex\Web3\Providers\HTTPHandler;
use Litehex\Web3\Utils;

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
class Account
{

    /**
     * RPC Provider trait
     */
    use HTTPHandler;

    /**
     * @todo: Add below methods to this class:
     * -------------------------------------
     *
     * get
     * create
     * getAddress(publicKey)
     * privateKeyToAccount(privateKey)
     * signTransaction(transaction, privateKey)
     * recoverTransaction(signature)
     * hashMessage(message)
     * sign(data, privateKey)
     * recover(signatureObject)
     * encrypt(privateKey, password)
     * decrypt(keystoreJsonV3, password)
     * wallet
     */

    /**
     * Generates an account object with private key and public key.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth-accounts.html#create
     *
     * @param string $entropy A random string to increase entropy.
     * @return array
     */
    #[ArrayShape(['privateKey' => "string", 'publicKey' => "string"])]
    public function create(string $entropy): array
    {
        $kPair = KeyPair::generate($entropy);

        return [
            'privateKey' => $kPair->getPrivateKey(),
            'publicKey' => $kPair->getPublicKey()
        ];
    }

    /**
     * Returns the address of an account.
     *
     * @param string $publicKey
     *
     * @return string
     * @throws \Exception
     */
    public function getAddress(string $publicKey): string
    {
        return '0x' . substr(Utils::sha3($publicKey), -40);
    }

    /**
     * Returns an account object from a private key.
     *
     * @param string $privateKey
     * @return array
     */
    #[ArrayShape(['privateKey' => "string", 'publicKey' => "string"])]
    public function privateKeyToAccount(string $privateKey): array
    {
        $kPair = KeyPair::fromPrivateKey($privateKey);

        return [
            'privateKey' => $kPair->getPrivateKey(),
            'publicKey' => $kPair->getPublicKey()
        ];
    }

    /**
     * Signs arbitrary data.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth-accounts.html#sign
     *
     * @param string $data
     * @param string $privateKey
     * @return array
     */
    #[ArrayShape(['message' => "string", 'messageHash' => "string", 'v' => "string", 'r' => "string", 's' => "string", 'signature' => "string"])]
    public function sign(string $data, string $privateKey): array
    {
        $kPair = KeyPair::fromPrivateKey($privateKey);
        $signature = $kPair->sign($data);

        return [
            'message' => $data,
            'messageHash' => $signature->getMessageHash(),
            'v' => $signature->getV(),
            'r' => $signature->getR(),
            's' => $signature->getS(),
            'signature' => $signature->getSignature()
        ];
    }

    /**
     * @return Wallet
     */
    public function wallet(): Wallet
    {
        return new Wallet($this->providerUrl, $this->headers);
    }

}