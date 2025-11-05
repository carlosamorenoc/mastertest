<?php
namespace Company\HealthCheck\Model\Api;

use Company\HealthCheck\Api\HealthCheckInterface;
use Company\HealthCheck\Api\Data\HealthCheckResponseInterfaceFactory;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\App\ResourceConnection;
use Psr\Log\LoggerInterface;

class HealthCheck implements HealthCheckInterface
{
    /**
     * @var HealthCheckResponseInterfaceFactory
     */
    protected $responseFactory;

    /**
     * @var ProductMetadataInterface
     */
    protected $productMetadata;

    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(
        HealthCheckResponseInterfaceFactory $responseFactory,
        ProductMetadataInterface $productMetadata,
        ResourceConnection $resourceConnection,
        LoggerInterface $logger
    ) {
        $this->responseFactory = $responseFactory;
        $this->productMetadata = $productMetadata;
        $this->resourceConnection = $resourceConnection;
        $this->logger = $logger;
    }

    /**
     * @return \Company\HealthCheck\Api\Data\HealthCheckResponseInterface
     */
    public function check()
    {
        $status = 'ok';
        $message = 'El sistema está funcionando correctamente';

        try {
            $connection = $this->resourceConnection->getConnection();
            $connection->fetchOne('SELECT 1');
            $dbStatus = 'ok';
        } catch (\Exception $e) {
            $this->logger->error('HealthCheck DB error: ' . $e->getMessage());
            $status = 'error';
            $message = 'Fallo de conexión con la base de datos';
            $dbStatus = 'error';
        }

        $response = $this->responseFactory->create();
        $response->setStatus($status)
                 ->setMessage($message)
                 ->setMagentoVersion($this->productMetadata->getVersion())
                 ->setPhpVersion(phpversion())
                 ->setDbStatus($dbStatus)
                 ->setTimestamp(date('Y-m-d H:i:s'));

        return $response;
    }
}
