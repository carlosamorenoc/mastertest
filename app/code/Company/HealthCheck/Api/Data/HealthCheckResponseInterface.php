<?php
namespace Company\HealthCheck\Api\Data;

/**
 * Interface HealthCheckResponseInterface
 * @api
 */
interface HealthCheckResponseInterface
{
    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param string $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @param string $message
     * @return $this
     */
    public function setMessage($message);

    /**
     * @return string
     */
    public function getMagentoVersion();

    /**
     * Establece la versión de Magento.
     *
     * @param string $version
     * @return $this
     */
    public function setMagentoVersion($version);

    /**
     * @return string
     */
    public function getPhpVersion();

    /**
     * @param string $version
     * @return $this
     */
    public function setPhpVersion($version);

    /**
     * @return string
     */
    public function getDbStatus();

    /**
     * @param string $status
     * @return $this
     */
    public function setDbStatus($status);

    /**
     * @return string
     */
    public function getTimestamp();

    /**
     * @param string $timestamp
     * @return $this
     */
    public function setTimestamp($timestamp);
}
