<?php
namespace Company\HealthCheck\Api;

interface HealthCheckInterface
{
    /**
     * @return \Company\HealthCheck\Api\Data\HealthCheckResponseInterface
     */
    public function check();
}
