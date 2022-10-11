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
class Web3 extends Provider
{

    /**
     * @var Eth
     */
    protected Eth $eth;

    /**
     * @var Net
     */
    protected Net $net;

    /**
     * @var Personal
     */
    protected Personal $personal;

    /**
     * @var Shh
     */
    protected Shh $shh;

    /**
     * @return Eth
     */
    public function getEth(): Eth
    {
        if (!isset($this->eth)) {
            $this->eth = new Eth($this->providerUrl, $this->headers);
        }
        return $this->eth;
    }

    /**
     * @return Net
     */
    public function getNet(): Net
    {
        if (!isset($this->net)) {
            $this->net = new Net($this->providerUrl, $this->headers);
        }
        return $this->net;
    }

    /**
     * @return Shh
     */
    public function getShh(): Shh
    {
        if (!isset($this->shh)) {
            $this->shh = new Shh($this->providerUrl, $this->headers);
        }
        return $this->shh;
    }

    /**
     * @return Personal
     */
    public function getPersonal(): Personal
    {
        if (!isset($this->personal)) {
            $this->personal = new Personal($this->providerUrl, $this->headers);
        }
        return $this->personal;
    }

    /**
     * Get the version of the web3 client.
     *
     *
     * @return string
     */
    public function getClientVersion(): string
    {
        return $this->request('web3_clientVersion')['result'];
    }

    /**
     * Get the SHA3 of the given data.
     *
     * @param string $data
     * @return string
     */
    public function sha3(string $data): string
    {
        return $this->request('web3_sha3', [$data])['result'];
    }

}