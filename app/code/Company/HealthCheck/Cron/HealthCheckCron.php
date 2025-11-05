<?php
namespace Company\HealthCheck\Cron;

use Company\HealthCheck\Model\Api\HealthCheck;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HealthCheckCron extends Command
{
    protected $healthCheck;
    protected $logger;

    public function __construct(
        HealthCheck $healthCheck,
        LoggerInterface $logger
    ) {
        $this->healthCheck = $healthCheck;
        $this->logger = $logger;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure() {
        $this->setName('inter:healthcheck:run')
                ->setDescription('Ejecuta el chequeo de salud');
        parent::configure();
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $result = $this->healthCheck->check();

            $data = [
                'status' => $result->getStatus(),
                'message' => $result->getMessage(),
                'magento_version' => $result->getMagentoVersion(),
                'php_version' => $result->getPhpVersion(),
                'db_status' => $result->getDbStatus(),
                'timestamp' => $result->getTimestamp(),
            ];

            $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            $output->writeln('<info>' . $json . '</info>');

            $this->logger->info('[HealthCheck CRON] ' . $json);
        } catch (\Exception $e) {
            $this->logger->error('[HealthCheck CRON ERROR] ' . $e->getMessage());
        }

        return 1;
    }
}
