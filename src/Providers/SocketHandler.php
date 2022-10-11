<?php declare(strict_types=1);

namespace Litehex\Web3\Providers;

use EasyHttp\Exceptions\ConnectionException;
use EasyHttp\SocketClient;
use EasyHttp\WebSocket;
use EasyHttp\WebSocketConfig;

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
trait SocketHandler
{

    /**
     * Socket
     *
     * @var WebSocket
     */
    protected WebSocket $socket;

    /**
     * Make config
     *
     * @param array $headers
     * @param array $context
     *
     * @return WebSocketConfig
     */
    protected function makeConfig(array $headers = [], array $context = []): WebSocketConfig
    {
        return (new WebSocketConfig())->setHeaders($headers)->setContextOptions([
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ],
            ...$context
        ]);
    }

    /**
     * Subscribe to a websocket
     *
     * @param string $url The websocket url that you want to subscribe to (starts with ws:// or wss://)
     * @param SocketClient $client The web socket client
     * @param array $options [optional] The options for the subscription. headers, timeout, etc.
     *
     * @return void
     * @throws ConnectionException
     */
    public function subscribe(string $url, SocketClient $client, array $options = []): void
    {
        if (!str_starts_with($url, 'ws://') && !str_starts_with($url, 'wss://')) {
            throw new ConnectionException('Invalid websocket url');
        }

        $this->socket = new WebSocket($client);
        $this->socket->connect($url, $this->makeConfig()); // TODO: Config is not customizable
    }

}