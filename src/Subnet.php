<?php
namespace Ip;

/**
 * Class Subnet
 */
class Subnet
{
    /**
     * @var Ip
     */
    private $netIp;
    /**
     * @var int
     */
    private $bitmask;


    /**
     * Subnet constructor.
     * @param string $net
     * @throws SubnetException
     */
    public function __construct(string $net)
    {
        list($ip, $mask) = explode('/', $net);

        if ($mask === null) {
            throw new SubnetException('Mask must be set.');
        }

        $this->netIp = new Ip($ip);
        $this->bitmask = $this->extractBitmask($mask);
    }

    /**
     * @param $ip
     * @return bool
     */
    public function contains(string $ip): bool
    {
        $ip = new Ip($ip);

        if ($this->netIp->getVersion() !== $ip->getVersion()) {
            return false;
        }

        if (base_convert($this->netIp->toBin(), 2, 10) === '0') {
            return true;
        }

        return substr($ip->toBin(), 0, $this->bitmask) === substr($this->netIp->toBin(), 0, $this->bitmask);
    }

    /**
     * @param string $mask
     * @return int
     * @throws SubnetException
     */
    private function extractBitmask(string $mask): int
    {
        if (!ctype_digit($mask) && $this->netIp->isIpv4()) {
            $long = ip2long($mask);
            $base = ip2long('255.255.255.255');
            $mask = 32 - log(($long ^ $base) + 1, 2);
        }

        if ($mask < 0 || $mask > $this->netIp->getLength()) {
            throw new SubnetException('Invalid net mask.');
        }

        return (int)$mask;
    }
}
