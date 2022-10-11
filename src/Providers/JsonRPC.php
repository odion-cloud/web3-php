<?php declare(strict_types=1);

namespace Litehex\Web3\Providers;

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
trait JsonRPC
{

    /**
     * CurrentProvider RPC Url
     *
     * @var string
     */
    public string $providerUrl;

    /**
     * rpcVersion
     *
     * @var string
     */
    protected string $rpcVersion = '2.0';

    /**
     * id
     *
     * @var int
     */
    protected int $id = 0;

}