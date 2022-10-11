<?php declare(strict_types=1);

namespace Litehex\Web3\Providers;

use EasyHttp\Client;
use EasyHttp\HttpClient;
use Litehex\Web3\Exception\InvalidResponseException;

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
trait HTTPHandler
{

    use JsonRPC;

    /**
     * Additional headers
     *
     * @var array
     */
    protected array $headers = [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ];

    /**
     * @param string $rpc
     * @param array $config [optional]
     */
    public function __construct(string $rpc = '', array $config = [])
    {
        if (!empty($rpc)) {
            $this->providerUrl = $rpc;
        }

        if (!empty($config)) {
            $this->headers = array_merge(
                $this->headers,
                $config
            );
        }
    }

    /**
     * Send request to RPC
     *
     * @param string $method
     * @param array $params
     * @return array
     */
    protected function request(string $method, array $params = []): array
    {
        $payload = json_encode([
            'jsonrpc' => $this->rpcVersion,
            'method' => $method,
            'params' => $params,
            'id' => $this->id++,
        ]);

        $response = (new HttpClient())->post($this->providerUrl, [
            'headers' => $this->headers,
            'body' => $payload
        ]);

        if ($response->getStatusCode() !== 200) {
            if (is_int($response->getStatusCode())) {
                throw new InvalidResponseException(sprintf(
                    'Invalid response code: %s',
                    $response->getStatusCode()
                ));
            }

            throw new \RuntimeException($response->getErrorMessage());
        }

        $message = json_decode($response->getBody(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidResponseException('Invalid response body: ' . $response->getBody());
        }

        if (isset($message['error'])) {
            [$code, $message] = array_values($message['error']);
            throw new InvalidResponseException($message, $code);
        }

        return $message;
    }

}