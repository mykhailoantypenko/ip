<?php

use PHPUnit\Framework\TestCase;
use Ip\Subnet;

/**
 * Class SubnetTest
 */
class SubnetTest extends TestCase
{
    /**
     * @dataProvider containsDataProvider
     * @param string $net
     * @param string $ip
     * @param bool $expected
     */
    public function testContains($net, $ip, $expected)
    {
        $subnet = new Subnet($net);
        $this->assertSame($expected, $subnet->contains($ip));
    }

    /**
     * @return array
     */
    public function containsDataProvider()
    {
        return [
            ['192.0.2.235/24', '192.0.2.0', true],
            ['192.0.2.235/24', '192.0.255.0', false],
            ['192.0.2.235/255.255.255.0', '192.0.2.0', true],
            ['192.0.2.235/255.255.255.0', '192.0.255.0', false],
            ['192.0.2.235/255.255.255.0', '2001:db0:1:2::7', false],

            ['10.210.12.12/7', '11.255.255.255', true],
            ['10.210.12.12/7', '12.255.255.255', false],
            ['10.210.12.12/254.0.0.0', '11.255.255.255', true],
            ['10.210.12.12/254.0.0.0', '12.255.255.255', false],

            ['0.0.0.0/32', '0.0.0.0', true],
            ['0.0.0.0/32', '255.255.255.254', true],

            ['2001:db8:abcd:12::0/80', '2001:db8:abcd:0012:0:5::', true],
            ['2001:db8:abcd:12::0/80', '2001:db8:abcd:0012:f::', false],

            ['::/0', '2001:db8:abcd:0012:0:5::', true],
            ['::/0', '3001:db8:7777::', true],

            ['2001:db0:1:1::/64', '2001:db0:1:1::6', true],
            ['2001:db0:1:1::/64', '2001:db0:1:2::7', false],
            ['2001:db0:1:2::/64', '2001:db0:1:2::7', true],
            ['2001:db0:1:2::/64', '192.0.255.0', false],

            ['babe::/8', 'cafe::babe', false],
            ['babe::/8', 'babe::cafe', true],
        ];
    }
}
