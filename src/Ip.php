<?php
namespace Ip;

/**
 * Class Ip
 */
class Ip
{
    const IPV4_LENGTH = 32;
    const IPV6_LENGTH = 128;

    private $ip;
    private $ipv4 = false;
    private $ipv6 = false;


    /**
     * Ip constructor.
     * @param string $ip
     * @throws IpException
     */
    public function __construct(string $ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $this->ipv4 = true;
            $this->ip = $ip;
        } elseif (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $this->ipv6 = true;
            $hex = unpack('H*hex', inet_pton($ip));
            $this->ip = substr(preg_replace('/([a-f0-9]{4})/i', '$1:', $hex['hex']), 0, -1);
        } else {
            throw new IpException('Invalid IP.');
        }
    }

    /**
     * @return string
     */
    public function toBin(): string
    {
        $inAddr = inet_pton($this->ip);
        $bytes = unpack('C*', $inAddr);
        $binIp = '';

        foreach ($bytes as $byte) {
            $binIp .= str_pad(decbin($byte), 8, '0', STR_PAD_LEFT);
        }

        return $binIp;
    }

    /**
     * @return bool
     */
    public function isIpv4()
    {
        return $this->ipv4;
    }

    /**
     * @return bool
     */
    public function isIpv6()
    {
        return $this->ipv6;
    }

    /**
     * @return int
     */
    public function getVersion()
    {
        return $this->ipv4 ? 4 : 6;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->ipv4 ? self::IPV4_LENGTH : self::IPV6_LENGTH;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->ip;
    }
}
