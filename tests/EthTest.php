<?php declare(strict_types=1);

namespace LitehexTests\Web3;

use Elliptic\EC;
use Litehex\Web3\Utils;
use phpseclib\Math\BigInteger;
use Web3p\EthereumTx\Transaction;

class EthTest extends \PHPUnit\Framework\TestCase
{

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        (new Environment())->load();
    }

    /**
     * testEth
     *
     * @return void
     */
    public function testEth(): void
    {
        $web3 = new \Litehex\Web3\Web3('https://rpc.ankr.com/eth');
        $this->assertInstanceOf(\Litehex\Web3\Eth::class, $web3->getEth());
    }

    /**
     * test get client version
     *
     * @return void
     */
    public function testGetClientVersion(): void
    {
        $web3 = new \Litehex\Web3\Web3('https://rpc.ankr.com/eth');
        $this->assertIsString($web3->getClientVersion());
    }

    /**
     * test sha3
     *
     * @return void
     */
    public function testSha3(): void
    {
        $web3 = new \Litehex\Web3\Web3('https://rpc.ankr.com/eth');
        $this->assertIsString($web3->sha3('0x68656c6c6f20776f726c64'));
    }

    /**
     * test get block number
     *
     * @return void
     */
    public function testGetBlockNumber(): void
    {
        $web3 = new \Litehex\Web3\Web3('https://rpc.ankr.com/eth');
        $block = $web3->getEth()->getBlockNumber();
        $this->assertIsString($block);
        $this->assertTrue(Utils::isHex($block));
        echo $block = Utils::hexToNumber($block)->toString();
        $this->assertIsInt((int)$block);
    }

    /**
     * test get balance
     *
     * @return void
     */
    public function testGetBalance(): void
    {
        $web3 = new \Litehex\Web3\Web3('https://rpc.ankr.com/eth');
        $balance = $web3->getEth()->getBalance('0x6EeC258a335b9241652be5575cb6E7d9b6028aA8');
        $this->assertIsString($balance);
        $this->assertTrue(Utils::isHex($balance));
        $balance = Utils::hexToNumber($balance)->toString();
        $this->assertIsInt((int)$balance);
    }

    /**
     * test get storage at
     *
     * @return void
     */
    public function testGetStorageAt(): void
    {
        $web3 = new \Litehex\Web3\Web3('https://rpc.ankr.com/eth');
        echo $storage = $web3->getEth()->getStorageAt('0x407d73d8a49eeb85d32cf465507dd71d507100c1', "0x0");
        $this->assertIsString($storage);
        $this->assertTrue(Utils::isHex($storage));
        $this->assertEquals("0", Utils::hexToNumber($storage)->toString());
    }

    /**
     * test get transaction count
     *
     * @return void
     */
    public function testGetTransactionCount(): void
    {
        $web3 = new \Litehex\Web3\Web3('https://rpc.ankr.com/eth');
        $count = $web3->getEth()->getTransactionCount('0xCBD6832Ebc203e49E2B771897067fce3c58575ac');
        $this->assertIsString($count);
        $this->assertTrue(Utils::isHex($count));
        echo $count = Utils::hexToNumber($count)->toString();
        $this->assertGreaterThan(157190, $count);
    }

    /**
     * test sign transaction
     *
     * @return void
     */
    public function testSignTransaction(): void
    {
        $web3 = new \Litehex\Web3\Web3($_ENV['WEB3_RPC_URL']);

        $key = (new EC('secp256k1'))->keyFromPrivate($_ENV['WALLET_PRIVATE_KEY']);
        $privateKey = $key->getPrivate('hex');

        $transactionCount = $web3->getEth()->getTransactionCount($_ENV['WALLET_ADDRESS']);
        $txCount = Utils::hexToNumber($transactionCount)->toString();
        echo "Transaction count: " . $txCount . PHP_EOL;

        $transaction = new Transaction([
            'nonce' => Utils::toHex(rand(1111, 9999), true),
            'from' => $_ENV['WALLET_ADDRESS'],
            'to' => '0xf29a6c0f8ee500dc87d0d4eb8b26a6fac7a76767',
            'value' => Utils::toHex(new BigInteger(10 ** 12), true),
            'gas' => Utils::toHex(21000, true),
            'gasPrice' => '0x5208',
            'chainId' => 11155111,
        ]);
        $signed = "0x" . $transaction->sign($privateKey);

        $this->assertIsString($signed);
        $this->assertEquals('0x', substr($signed, 0, 2));

        $hash = $web3->getEth()->sendSignedTransaction($signed);
        echo "Transaction hash: " . $hash . PHP_EOL;

        $this->assertTrue(Utils::isHex($hash));
    }

}