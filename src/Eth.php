<?php declare(strict_types=1);

namespace Litehex\Web3;

use EasyHttp\Exceptions\ConnectionException;
use EasyHttp\SocketClient;
use JetBrains\PhpStorm\ArrayShape;
use Litehex\Web3\Eth\Account;
use Litehex\Web3\Providers\Provider;
use phpseclib\Math\BigInteger;

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
class Eth extends Provider
{

    /**
     * @param string $rpc [optional]
     * @param array $headers [optional]
     */
    public function __construct(string $rpc = 'https://rpc.ankr.com/eth', array $headers = [])
    {
        parent::__construct($rpc, $headers);
    }

    /**
     * The default chain id.
     *
     * @var string
     */
    protected string $chainId = "0x1";

    /**
     * Symbol of the chain.
     *
     * @var string
     */
    protected string $symbol = "ETH";

    /**
     * Block explorer url.
     *
     * @var string
     */
    protected string $explorer = "https://etherscan.io";

    /**
     * @return Account
     */
    public function account(): Account
    {
        return new Account($this->providerUrl, $this->headers);
    }

    /**
     * Returns the current block number.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#getblocknumber
     *
     * @return string
     */
    public function getBlockNumber(): string
    {
        return $this->request('eth_blockNumber')['result'];
    }

    /**
     * Get the balance of an address at a given block.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#getbalance
     *
     * @param string $address The address to check for balance.
     * @param int|string|BigInteger $block The block number, or the string "latest", "earliest" or "pending".
     *
     * @return string
     */
    public function getBalance(string $address, int|string|BigInteger $block = 'latest'): string
    {
        return $this->request('eth_getBalance', [$address, $block])['result'];
    }

    /**
     * Get the storage at a specific position of an address.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#getstorageat
     *
     * @param string $address The address to check for balance.
     * @param int|string|BigInteger $position The position to check for storage.
     * @param int|string|BigInteger $block The block number, or the string "latest", "earliest" or "pending".
     *
     * @return string
     */
    public function getStorageAt(string $address, int|string|BigInteger $position, int|string|BigInteger $block = 'latest'): string
    {
        return $this->request('eth_getStorageAt', [$address, $position, $block])['result'];
    }

    /**
     * Get the code at a specific address.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#getcode
     *
     * @param string $address The address to get the code from.
     * @param int|string|BigInteger $block The block number, or the string "latest", "earliest" or "pending".
     *
     * @return string
     */
    public function getCode(string $address, int|string|BigInteger $block = 'latest'): string
    {
        return $this->request('eth_getCode', [$address, $block])['result'];
    }

    /**
     * Returns a block matching the block number or block hash.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#getblock
     *
     * @param int|string|BigInteger $block The block number, or the string "latest", "earliest" or "pending".
     * @param bool $full If true it returns the full transaction objects, if false only the hashes of the transactions.
     *
     * @return array
     */
    public function getBlock(int|string|BigInteger $block = 'latest', bool $full = false): array
    {
        return $this->request('eth_getBlockByNumber', [$block, $full])['result'];
    }

    /**
     * Returns the number of transaction in a given block.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#gettransactioncount
     *
     * @param int|string|BigInteger $block The block number, or the string "latest", "earliest" or "pending".
     *
     * @return string
     */
    public function getBlockTransactionCount(int|string|BigInteger $block = 'latest'): string
    {
        return $this->request('eth_getBlockTransactionCountByNumber', [$block])['result'];
    }

    /**
     * Returns the number of uncles in a block from a block matching the given block hash.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#getunclecountbyblockhash
     *
     * @param int|string|BigInteger $block The block number or hash. Or the string "latest", "earliest" or "pending".
     *
     * @return string
     */
    public function getBlockUncleCount(int|string|BigInteger $block = 'latest'): string
    {
        return $this->request('eth_getUncleCountByBlockNumber', [$block])['result'];
    }

    /**
     * Returns a blocks uncle by a given uncle index position.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#getunclebyblocknumberandindex
     *
     * @param int|string|BigInteger $block The block number or hash. Or the string "latest", "earliest" or "pending".
     * @param int|string|BigInteger $index The uncle's index position.
     * @param bool $full If true it returns the full transaction objects, if false only the hashes of the transactions.
     *
     * @return array
     */
    public function getUncle(int|string|BigInteger $block, int|string|BigInteger $index, bool $full = false): array
    {
        return $this->request('eth_getUncleByBlockNumberAndIndex', [$block, $index, $full])['result'];
    }

    /**
     * Returns the transaction with the given hash.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#gettransactionbyhash
     *
     * @param string $hash The hash of the transaction.
     *
     * @return array
     */
    public function getTransaction(string $hash): array
    {
        return $this->request('eth_getTransactionByHash', [$hash])['result'];
    }

    /**
     * Returns a list of pending transactions.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#getpendingtransactions
     *
     * @return array
     */
    public function getPendingTransactions(): array
    {
        return $this->request('eth_getPendingTransactions')['result'];
    }

    /**
     * Returns a transaction based on a block hash or number and the transaction’s index position.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#gettransactionreceipt
     *
     * @param int|string|BigInteger $block The block number or hash. Or the string "latest", "earliest" or "pending".
     * @param int|string|BigInteger $index The transaction's index position.
     *
     * @return array
     */
    public function getTransactionFromBlock(int|string|BigInteger $block, int|string|BigInteger $index): array
    {
        return $this->request('eth_getTransactionByBlockNumberAndIndex', [$block, $index])['result'];
    }

    /**
     * Returns the receipt of a transaction by transaction hash.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#gettransactionreceipt
     *
     * @param string $hash The hash of the transaction.
     * @param string $hex [optional] The hex string of the transaction.
     *
     * @return array
     */
    public function getTransactionReceipt(string $hash, string $hex = ''): array
    {
        return $this->request('eth_getTransactionReceipt', [$hash, $hex])['result'];
    }

    /**
     * Get the number of transactions sent from this address.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#gettransactioncount
     *
     * @param string $address The address to get the transaction count from.
     * @param int|string|BigInteger $block The block number, or the string "latest", "earliest" or "pending".
     *
     * @return string
     */
    public function getTransactionCount(string $address, int|string|BigInteger $block = 'latest'): string
    {
        return $this->request('eth_getTransactionCount', [$address, $block])['result'];
    }

    /**
     * Sends a transaction to the network.
     *
     * NOTE: Not Available In Public Nodes.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#sendtransaction
     *
     * @param array $transaction The transaction object.
     *
     * @return string
     */
    public function sendTransaction(array $transaction): string
    {
        return $this->request('eth_sendTransaction', [$transaction])['result'];
    }

    /**
     * Sends an already signed transaction, generated for example using web3.eth.accounts.signTransaction.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#sendsignedtransaction
     *
     * @param string $hex Signed transaction data in HEX format
     *
     * @return string
     */
    public function sendSignedTransaction(string $hex): string
    {
        return $this->request('eth_sendRawTransaction', [$hex])['result'];
    }

    /**
     * Signs data using a specific account. This account needs to be unlocked.
     *
     * NOTE: Not Available In Public Nodes.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#sign
     *
     * @param string $message The data to sign.
     * @param string $address Address to sign data with.
     *
     * @return string
     */
    public function sign(string $message, string $address): string
    {
        return $this->request('eth_sign', [$message, $address])['result'];
    }

    /**
     * Executes a message call transaction, which is directly executed in the VM of the node, but never mined
     * into the blockchain.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#call
     *
     * @param array $transaction The transaction object.
     * @param int|string|BigInteger $block The block number, or the string "latest", "earliest" or "pending".
     *
     * @return string
     */
    public function call(array $transaction, int|string|BigInteger $block = 'latest'): string
    {
        return $this->request('eth_call', [$transaction, $block])['result'];
    }

    /**
     * Creates new message call transaction or a contract creation, if the data field contains code.
     *
     * NOTE: Not Available In Public Nodes.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#estimategas
     *
     * @param array $transaction {from: hexAddress, to: hexAddress, value: hex}
     *
     * @return string
     */
    public function estimateGas(array $transaction): string
    {
        if (!isset($transaction['from'], $transaction['to'], $transaction['value'])) {
            throw new \InvalidArgumentException(sprintf(
                'The transaction object must contain the following keys: %s',
                implode(', ', ['from', 'to', 'value'])
            ));
        }

        return $this->request('eth_estimateGas', [$transaction])['result'];
    }

    /**
     * Returns the current gas price oracle.
     *
     * @return string Integer value of current gas price in wei.
     */
    public function getGasPrice(): string
    {
        return $this->request('eth_gasPrice')['result'];
    }

    /**
     * Gets past logs, matching the given options.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#getpastlogs
     *
     * @param array $options
     *
     * @return array
     */
    #[ArrayShape([
        'data' => "string",
        'topics' => "array",
        'logIndex' => "string",
        'transactionIndex' => "string",
        'transactionHash' => "string",
        'blockHash' => "string",
        'blockNumber' => "int",
        'address' => "string"
    ])]
    public function getPastLogs(array $options): array
    {
        return $this->request('eth_getLogs', [$options]);
    }

    /**
     * Gets work for miners to mine on. Returns the hash of the current block, the seedHash, and
     * the boundary condition to be met (“target”).
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#getwork
     *
     * @return array [hash, seedHash, target]
     */
    #[ArrayShape([
        'hash' => "string",
        'seedHash' => "string",
        'target' => "string"
    ])]
    public function getWork(): array
    {
        $result = $this->request('eth_getWork')['result'];
        return [
            'hash' => $result[0],
            'seedHash' => $result[1],
            'target' => $result[2],
        ];
    }

    /**
     * Submits a proof-of-work solution.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#submitwork
     *
     * @param string $nonce The nonce found (64 bits).
     * @param string $powHash The header's pow-hash (256 bits).
     * @param string $mixDigest The mix digest (256 bits).
     *
     * @return bool
     */
    public function submitWork(string $nonce, string $powHash, string $mixDigest): bool
    {
        return $this->request('eth_submitWork', [$nonce, $powHash, $mixDigest])['result'];
    }

    /**
     * Submits mining hashrate.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#submithashrate
     *
     * @param string $hashrate A hexadecimal string representation (32 bytes) of the hash rate.
     * @param string $id A random hexadecimal(32 bytes) ID identifying the client.
     *
     * @return bool
     */
    public function submitHashrate(string $hashrate, string $id): bool
    {
        return $this->request('eth_submitHashrate', [$hashrate, $id])['result'];
    }

    /**
     * Returns the chain ID of the current connected node as described in the EIP-695.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#getchainid
     *
     * @return string
     */
    public function getChainId(): string
    {
        return $this->request('eth_chainId')['result'];
    }

    /**
     * Returns the current node information.
     *
     * @link https://web3js.readthedocs.io/en/v1.8.0/web3-eth.html#getnodeinfo
     *
     * @return string
     */
    public function getNodeInfo(): string
    {
        return $this->request('admin_nodeInfo')['result'];
    }

    /**
     * @todo Implement below methods.
     *
     * contract
     */

}