<?php declare(strict_types=1);

namespace LitehexTests\Web3\Util;

use Litehex\Web3\Utils;

class BloomFiltersTest extends \PHPUnit\Framework\TestCase
{


    public function testIsBloom()
    {
        $this->assertTrue(Utils::isBloom('0x15ac582820ce219071f520ac98b0fc458059117dac1099491493a45ad0e48b81051e214c658816f457107a028c1a8b5d862ee083d93a2aa76c8db1b0baee4259594c408aa112a96e4dc3cc8cd3f9c76698464147114614138cc61c48da4b5551fd4089951a304361134dd841636d9cea4f4d1328442a1fd10a7e7f3a122c5da059b9d9068b682684ddeb48140206a4170c0e8c9f85383629e126bce1869e91b68329681bfe59f3027e85f2f4ba11091902458c41882a59402278a30911288256b950a063253e8ab4144c4d72b3bbac8f0465df4b574b53dae81988474c48a0a51eb86810baa2c0458c501df0f1b85300952c00d205cf2c7108ec8676039256fa'));
        $this->assertFalse(Utils::isBloom('0xa9059cbb000000000000000000000000412dd63477eac1cb5531cb2061345b23ae3de4ee0000000000000000000000000000000000000000000000000000002098a637ab'));
        $this->assertFalse(Utils::isBloom('0x1614e81a28ded92a9d55ea9fa9ccb577c4111f45920de0f7fc789d5588dea8f9'));
    }

    public function testIsUserEthereumAddressInBloom()
    {
//        $this->assertTrue(Utils::isUserEthereumAddressInBloom(
//            '0x52bc44d5378309ee2abf1539bf71de1b7d7be3b5',
//            '0x15ac582820ce219071f520ac98b0fc458059117dac1099491493a45ad0e48b81051e214c658816f457107a028c1a8b5d862ee083d93a2aa76c8db1b0baee4259594c408aa112a96e4dc3cc8cd3f9c76698464147114614138cc61c48da4b5551fd4089951a304361134dd841636d9cea4f4d1328442a1fd10a7e7f3a122c5da059b9d9068b682684ddeb48140206a4170c0e8c9f85383629e126bce1869e91b68329681bfe59f3027e85f2f4ba11091902458c41882a59402278a30911288256b950a063253e8ab4144c4d72b3bbac8f0465df4b574b53dae81988474c48a0a51eb86810baa2c0458c501df0f1b85300952c00d205cf2c7108ec8676039256fa'
//        ));
//        $this->assertFalse(Utils::isUserEthereumAddressInBloom(
//            '0xdac17f958d2ee523a2206206994597c13d831ec6',
//            '0x15ac582820ce219071f520ac98b0fc458059117dac1099491493a45ad0e48b81051e214c658816f457107a028c1a8b5d862ee083d93a2aa76c8db1b0baee4259594c408aa112a96e4dc3cc8cd3f9c76698464147114614138cc61c48da4b5551fd4089951a304361134dd841636d9cea4f4d1328442a1fd10a7e7f3a122c5da059b9d9068b682684ddeb48140206a4170c0e8c9f85383629e126bce1869e91b68329681bfe59f3027e85f2f4ba11091902458c41882a59402278a30911288256b950a063253e8ab4144c4d72b3bbac8f0465df4b574b53dae81988474c48a0a51eb86810baa2c0458c501df0f1b85300952c00d205cf2c7108ec8676039256fa'
//        ));
        $this->assertTrue(true);
    }

    public function testIsTopic()
    {
        $this->assertTrue(true);
    }
    public function testIsInBloom()
    {
        $this->assertTrue(true);
    }

    public function testIsTopicInBloom()
    {
        $this->assertTrue(true);
    }

    public function testIsContractAddressInBloom()
    {
        $this->assertTrue(true);
    }

}