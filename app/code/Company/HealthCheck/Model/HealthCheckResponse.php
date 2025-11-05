<?php
namespace Company\HealthCheck\Model;

use Company\HealthCheck\Api\Data\HealthCheckResponseInterface;
use Magento\Framework\DataObject;

class HealthCheckResponse extends DataObject implements HealthCheckResponseInterface
{
    public function getStatus()
    {
        return $this->getData('status');
    }
    public function setStatus($status)
    {
        return $this->setData('status', $status);
    }

    public function getMessage()
    {
        return $this->getData('message');
    }
    public function setMessage($message)
    {
        return $this->setData('message', $message);
    }

    public function getMagentoVersion()
    {
        return $this->getData('magento_version');
    }
    public function setMagentoVersion($version)
    {
        return $this->setData('magento_version', $version);
    }

    public function getPhpVersion()
    {
        return $this->getData('php_version');
    }
    public function setPhpVersion($version)
    {
        return $this->setData('php_version', $version);
    }

    public function getDbStatus()
    {
        return $this->getData('db_status');
    }
    public function setDbStatus($status)
    {
        return $this->setData('db_status', $status);
    }

    public function getTimestamp()
    {
        return $this->getData('timestamp');
    }
    public function setTimestamp($timestamp)
    {
        return $this->setData('timestamp', $timestamp);
    }
}
