<?php declare(strict_types=1);

namespace Litehex\Web3;

use Litehex\Web3\Providers\Provider;

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
class Personal extends Provider
{

    /**
     * Creates a new account.
     *
     * @link https://web3js.readthedocs.io/en/v1.2.0/web3-eth-personal.html#newaccount
     *
     * @param string $password
     * @return array
     */
    public function newAccount(string $password): array
    {
        return $this->request('personal_newAccount', [$password]);
    }

    /**
     * Signs arbitrary data.
     *
     * @link https://web3js.readthedocs.io/en/v1.2.0/web3-eth-personal.html#sign
     *
     * @param string $data
     * @param string $address
     * @param string $password
     * @return array
     */
    public function sign(string $data, string $address, string $password): array
    {
        return $this->request('personal_sign', [$data, $address, $password]);
    }

    /**
     * Recovers the Ethereum address which was used to sign the given data.
     *
     * @link https://web3js.readthedocs.io/en/v1.2.0/web3-eth-personal.html#ecrecover
     *
     * @param string $message
     * @param string $signature
     * @return array
     */
    public function ecRecover(string $message, string $signature): array
    {
        return $this->request('personal_ecRecover', [$message, $signature]);
    }

    /**
     * Signs a transaction.
     *
     * @link https://web3js.readthedocs.io/en/v1.2.0/web3-eth-personal.html#signtransaction
     *
     * @param array $transaction
     * @param string $password
     * @return array
     */
    public function signTransaction(array $transaction, string $password): array
    {
        return $this->request('personal_signTransaction', [$transaction, $password]);
    }

    /**
     * Unlocks an account.
     *
     * @link https://web3js.readthedocs.io/en/v1.2.0/web3-eth-personal.html#unlockaccount
     *
     * @param string $address
     * @param string $password
     * @param int $duration
     * @return array
     */
    public function unlockAccount(string $address, string $password, int $duration): array
    {
        return $this->request('personal_unlockAccount', [$address, $password, $duration]);
    }

}