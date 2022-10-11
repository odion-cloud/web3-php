<?php declare(strict_types=1);

namespace LitehexTests\Web3;

class UtilsTest extends \PHPUnit\Framework\TestCase
{

    /**
     * testIsAddress
     *
     * @return void
     */
    public function testIsAddress(): void
    {
        $this->assertTrue(\Litehex\Web3\Utils::isAddress('0x407d73d8a49eeb85d32cf465507dd71d507100c1'));
        $this->assertTrue(\Litehex\Web3\Utils::isAddress('0x407d73d8a49eeb85d32cf465507dd71d507100c1'));
        $this->assertTrue(\Litehex\Web3\Utils::isAddress('0x5A0b54D5dc17e0AadC383d2db43B0a0D3E029c4c'));
        $this->assertFalse(\Litehex\Web3\Utils::isAddress('0x407d73d8a49eeb85d32cf465507dd71d507100c'));
        $this->assertFalse(\Litehex\Web3\Utils::isAddress('0x407d73d8a49eeb85d32cf465507dd71d507100cF'));
        $this->assertFalse(\Litehex\Web3\Utils::isAddress('0x407d73d8a49eeb85d32cf465507dd71d507100cg'));
    }

    /**
     * testIsChecksumAddress
     *
     * @return void
     */
    public function testIsChecksumAddress(): void
    {
        $this->assertTrue(\Litehex\Web3\Utils::isChecksumAddress('0x52908400098527886E0F7030069857D2E4169EE7'));
        $this->assertTrue(\Litehex\Web3\Utils::isChecksumAddress('0x8617E340B3D01FA5F11F306F4090FD50E238070D'));
        $this->assertTrue(\Litehex\Web3\Utils::isChecksumAddress('0xde709f2102306220921060314715629080e2fb77'));
        $this->assertFalse(\Litehex\Web3\Utils::isChecksumAddress('0x407d73d8a49eeb85d32cf465507dd71d507100cg'));
        $this->assertFalse(\Litehex\Web3\Utils::isChecksumAddress('0x407d73d8a49eeb85d32cf465507dd71d507100cF'));
        $this->assertFalse(\Litehex\Web3\Utils::isChecksumAddress('0x27b1fdb04752bbc536007a920d24aacb045561c26'));
    }

}