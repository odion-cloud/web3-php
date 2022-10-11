<?php declare(strict_types=1);

namespace LitehexTests\Web3;

class Web3Test extends \PHPUnit\Framework\TestCase
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
        $web3 = new \Litehex\Web3\Web3($_ENV['WEB3_RPC_URL']);
        $this->assertInstanceOf(\Litehex\Web3\Eth::class, $web3->getEth());
    }

    /**
     * test get client version
     *
     * @return void
     */
    public function testGetClientVersion(): void
    {
        $web3 = new \Litehex\Web3\Web3($_ENV['WEB3_RPC_URL']);
        $this->assertIsString($web3->getClientVersion());
    }

    /**
     * test sha3
     *
     * @return void
     */
    public function testSha3(): void
    {
        $web3 = new \Litehex\Web3\Web3($_ENV['WEB3_RPC_URL']);
        $this->assertIsString($web3->sha3('0x68656c6c6f20776f726c64'));
    }

}