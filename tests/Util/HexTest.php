<?php declare(strict_types=1);

namespace LitehexTests\Web3\Util;

use Litehex\Web3\Utils;

class HexTest extends \PHPUnit\Framework\TestCase
{

    /**
     * testRandomHex
     *
     * @return void
     * @throws \Exception
     */
    public function testRandomHex(): void
    {
        $hex = Utils::randomHex(4); // 0x6892ffc6
        $this->assertTrue(Utils::isHex($hex));
        $this->assertEquals(10, strlen($hex));
    }

    /**
     * testIsHex
     *
     * @return void
     */
    public function testIsHex(): void
    {
        $this->assertTrue(Utils::isHex('0x0'));
        $this->assertTrue(Utils::isHex('0xea'));
        $this->assertTrue(Utils::isHex('0xffffffff'));
    }

    /**
     * testIsHexStrict
     *
     * @return void
     */
    public function testIsHexStrict(): void
    {
        $this->assertTrue(Utils::isHexStrict('0xc1912'));
        $this->assertFalse(Utils::isHexStrict(0xc1912));
        $this->assertFalse(Utils::isHexStrict('c1912'));
        $this->assertFalse(Utils::isHexStrict('345'));
        $this->assertFalse(Utils::isHexStrict('0xZ1912'));
        $this->assertFalse(Utils::isHexStrict('Hello World'));
    }

    /**
     * testHexToNumberString
     *
     * @return void
     */
    public function testHexToNumberString(): void
    {
        $this->assertEquals('0', Utils::hexToNumberString('0x0'));
        $this->assertEquals('1', Utils::hexToNumberString('0x1'));
        $this->assertEquals('15', Utils::hexToNumberString('0xf'));
        $this->assertEquals('4294967295', Utils::hexToNumberString('0xffffffff'));
        $this->assertEquals('4294967296', Utils::hexToNumberString('0x100000000'));
        $this->assertEquals('18446744073709551615', Utils::hexToNumberString('0xffffffffffffffff'));
        $this->assertEquals('18446744073709551616', Utils::hexToNumberString('0x10000000000000000'));
    }

    /**
     * testHexToNumber
     *
     * @return void
     */
    public function testHexToNumber(): void
    {
        $this->assertInstanceOf(\phpseclib\Math\BigInteger::class, Utils::hexToNumber('0x0'));
        $this->assertEquals('0', Utils::hexToNumber('0x0')->toString());
        $this->assertEquals('1', Utils::hexToNumber('0x1')->toString());
        $this->assertEquals('15', Utils::hexToNumber('0xf')->toString());
    }

    /**
     * testNumberToHex
     *
     * @return void
     */
    public function testNumberToHex(): void
    {
        $this->assertEquals('0x0', Utils::numberToHex(0));
        $this->assertEquals('0x1', Utils::numberToHex(1));
        $this->assertEquals('0xf', Utils::numberToHex(15));
        $this->assertEquals('0x10', Utils::numberToHex(16));
        $this->assertEquals('0x100', Utils::numberToHex(256));
        $this->assertEquals('0x100000000', Utils::numberToHex(4294967296));
    }

    /**
     * testHexToUtf8
     *
     * @return void
     */
    public function testHexToUtf8(): void
    {
        $this->assertEquals('I have 100€', Utils::hexToUtf8('0x49206861766520313030e282ac'));
        $this->assertEquals('Hello World', Utils::hexToUtf8('0x48656c6c6f20576f726c64'));
    }

    /**
     * testHexToAscii
     *
     * @return void
     */
    public function testHexToAscii(): void
    {
        $this->assertEquals('I have 100!', Utils::hexToAscii('0x4920686176652031303021'));
        $this->assertEquals('Hello World', Utils::hexToAscii('0x48656c6c6f20576f726c64'));
    }

    /**
     * testUtf8ToHex
     *
     * @return void
     */
    public function testUtf8ToHex(): void
    {
        $this->assertEquals('0x49206861766520313030e282ac', Utils::utf8ToHex('I have 100€'));
        $this->assertEquals('0x48656c6c6f20576f726c64', Utils::utf8ToHex('Hello World'));
    }

    /**
     * testAsciiToHex
     *
     * @return void
     */
    public function testAsciiToHex(): void
    {
        $this->assertEquals('0x4920686176652031303021', Utils::asciiToHex('I have 100!'));
        $this->assertEquals('0x48656c6c6f20576f726c64', Utils::asciiToHex('Hello World'));
    }

    /**
     * testHexToBytes
     *
     * @return void
     */
    public function testHexToBytes(): void
    {
        $this->assertEquals([0, 0, 0, 234], Utils::hexToBytes('0x000000ea'));
        $this->assertEquals([0, 0, 0, 234], Utils::hexToBytes('0x000000eA'));
        $this->assertNotEquals([234], Utils::hexToBytes('0x000000ea')); // Should be [0, 0, 0, 234] ??
        $this->assertEquals([234], Utils::hexToBytes('0xea'));
    }

    /**
     * testBytesToHex
     *
     * @return void
     */
    public function testBytesToHex(): void
    {
        $this->assertEquals('0x000000ea', Utils::bytesToHex([0, 0, 0, 234]));
        $this->assertEquals('0x000000ea', Utils::bytesToHex([0, 0, 0, 234]));
        $this->assertNotEquals('0xea', Utils::bytesToHex([0, 0, 0, 234]));
        $this->assertEquals('0xea', Utils::bytesToHex([234]));
    }

}