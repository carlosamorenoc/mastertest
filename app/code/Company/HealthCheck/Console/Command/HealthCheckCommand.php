<?php
namespace Company\HealthCheck\Console\Command;

use Magento\Framework\Console\Cli;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\App\ProductMetadataInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HealthCheckCommand extends Command
{
    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var ProductMetadataInterface
     */
    private $productMetadata;

    public function __construct(
        ResourceConnection $resourceConnection,
        ProductMetadataInterface $productMetadata
    ) {
        $this->resourceConnection = $resourceConnection;
        $this->productMetadata = $productMetadata;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('company:health:check')
            ->setDescription('Verifica el estado de salud del sistema');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $status = 'ok';
        $message = 'El sistema está funcionando correctamente.';

        try {
            $this->resourceConnection->getConnection()->fetchOne('SELECT 1');
        } catch (\Exception $e) {
            $status = 'error';
            $message = 'Error en la conexión a la base de datos: ' . $e->getMessage();
        }

        $data = [
            'magento_version' => $this->productMetadata->getVersion(),
            'php_version' => phpversion(),
            'db_status' => $status === 'ok' ? 'ok' : 'error',
            'timestamp' => date('Y-m-d H:i:s')
        ];

        $output->writeln('');
        $output->writeln('<info>=== Verificación de Salud del Sistema ===</info>');
        $output->writeln('Estado: ' . ($status === 'ok' ? '<info>OK</info>' : '<error>ERROR</error>'));
        $output->writeln('Mensaje: ' . $message);
        $output->writeln('Magento versión: ' . $data['magento_version']);
        $output->writeln('PHP versión: ' . $data['php_version']);
        $output->writeln('Estado DB: ' . $data['db_status']);
        $output->writeln('Timestamp: ' . $data['timestamp']);
        $output->writeln('');

        return $status === 'ok' ? Cli::RETURN_SUCCESS : Cli::RETURN_FAILURE;
    }
}
