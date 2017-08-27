<?php

use PHPUnit\Framework\TestCase;
use Ip\Ip;

/**
 * Class IpTest
 */
class IpTest extends TestCase
{
    /**
     * @dataProvider constructorDataProvider
     * @param string $ip
     * @param string $expected
     */
    public function testConstructor($ip, $expected)
    {
        $this->assertSame($expected, (new Ip($ip))->__toString());
    }

    /**
     * @dataProvider toBinDataProvider
     * @param string $ip
     * @param string $expected
     */
    public function testToBin($ip, $expected)
    {
        $this->assertSame($expected, (new Ip($ip))->toBin());
    }

    /**
     * @dataProvider getLengthDataProvider
     * @param string $ip
     * @param int $expected
     */
    public function testGetLength($ip, $expected)
    {
        $this->assertSame($expected, (new Ip($ip))->getLength());
    }

    /**
     * @return array
     */
    public function getLengthDataProvider()
    {
        return [
            ['192.0.2.235', Ip::IPV4_LENGTH],
            ['0.0.0.0', Ip::IPV4_LENGTH],
            ['127.0.0.0', Ip::IPV4_LENGTH],
            ['2001:DB0:0:123A::30', Ip::IPV6_LENGTH],
            ['::1', Ip::IPV6_LENGTH],
            ['FE80::', Ip::IPV6_LENGTH],
        ];
    }

    /**
     * @return array
     */
    public function toBinDataProvider()
    {
        return [
            ['192.0.2.235', '11000000000000000000001011101011'],
            ['0.0.0.0', '00000000000000000000000000000000'],
            ['127.0.0.0', '01111111000000000000000000000000'],
            ['2001:0db8:0000:0000:0000:ff00:0042:8329', '00100000000000010000110110111000000000000000000000000000000000000000000000000000111111110000000000000000010000101000001100101001'],
            ['2001:DB0:0:123A::30', '00100000000000010000110110110000000000000000000000010010001110100000000000000000000000000000000000000000000000000000000000110000'],
            ['::1', '00000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000001'],
            ['FE80::', '11111110100000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'],
        ];
    }

    /**
     * @return array
     */
    public function constructorDataProvider()
    {
        return [
            ['192.0.2.235', '192.0.2.235'],
            ['0.0.0.0', '0.0.0.0'],
            ['127.0.0.0', '127.0.0.0'],
            ['2001:DB0:0:123A::30', '2001:0db0:0000:123a:0000:0000:0000:0030'],
            ['::1', '0000:0000:0000:0000:0000:0000:0000:0001'],
            ['FE80::', 'fe80:0000:0000:0000:0000:0000:0000:0000'],
        ];
    }
}
