<?php

namespace App\Tasks;

use Exception;
use SilverStripe\ORM\DB;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;

class PhpInfo extends BuildTask
{
    protected string $title = 'PHP Info';
    protected static string $description = 'Show environment information and phpinfo()';
    private static $segment = 'phpinfo';

    private bool $isCli = false;

    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        $this->isCli = Director::is_cli();

        // Start center wrapper for web output
        if (!$this->isCli) {
            echo '<center>';
        }

        // Environment Overview
        $this->outputHeader(_t(__CLASS__ . '.ENVIRONMENT_INFO', 'Environment Information'));
        $this->outputTable([
            [_t(__CLASS__ . '.BASE_URL', 'Base URL'), Environment::getEnv('SS_BASE_URL') ?: 'Not set'],
            [_t(__CLASS__ . '.BASE_PATH', 'BASE_PATH'), BASE_PATH],
            [_t(__CLASS__ . '.BASE_FOLDER', 'Director::baseFolder()'), Director::baseFolder()],
            [_t(__CLASS__ . '.SCRIPT_FILENAME', 'SCRIPT_FILENAME'), $_SERVER['SCRIPT_FILENAME'] ?? 'Not set'],
            [_t(__CLASS__ . '.SS_ENVIRONMENT', 'Silverstripe Environment'), $this->getEnvironmentMode()],
        ]);

        // Database Information
        $this->outputHeader(_t(__CLASS__ . '.DATABASE_INFO', 'Database Information'));
        $this->outputTable([
            [_t(__CLASS__ . '.DB_CONNECTION', 'Database Connection'), $this->getDatabaseStatus()],
            [_t(__CLASS__ . '.DB_NAME', 'Database Name'), $this->getDatabaseName()],
            [_t(__CLASS__ . '.DB_SERVER', 'Database Server'), Environment::getEnv('SS_DATABASE_SERVER') ?: 'Not set'],
            [_t(__CLASS__ . '.DB_USERNAME', 'Database Username'), Environment::getEnv('SS_DATABASE_USERNAME') ?: 'Not set'],
            [_t(__CLASS__ . '.DB_PORT', 'Database Port'), Environment::getEnv('SS_DATABASE_PORT') ?: 'Not set'],
            [_t(__CLASS__ . '.DB_CLASS', 'Database Class'), Environment::getEnv('SS_DATABASE_CLASS') ?: 'Not set'],
        ]);

        // Cache Configuration
        $this->outputHeader(_t(__CLASS__ . '.CACHE_CONFIG', 'Cache Configuration'));
        $this->outputTable($this->getCacheInfo());

        // End center wrapper for web output
        if (!$this->isCli) {
            echo '</center>';
        }

        // PHP Info with options
        $this->outputPhpInfo();

        return Command::SUCCESS;
    }

    private function outputHeader(string $title): void
    {
        if ($this->isCli) {
            echo "\n" . str_repeat('=', 60) . "\n";
            echo strtoupper($title) . "\n";
            echo str_repeat('=', 60) . "\n";
        } else {
            echo "<h2>{$title}</h2>";
        }
    }

    private function outputTable(array $data): void
    {
        if ($this->isCli) {
            $maxKeyLength = max(array_map(fn($row) => strlen($row[0]), $data));

            foreach ($data as $row) {
                $key = str_pad($row[0], $maxKeyLength);
                $value = strip_tags($row[1]); // Remove HTML tags for CLI
                echo "{$key}: {$value}\n";
            }
            echo "\n";
        } else {
            echo '<table border="1" cellpadding="5" cellspacing="0" style="border-collapse: collapse;">';
            echo '<tr><th>Setting</th><th>Value</th></tr>';
            foreach ($data as $row) {
                echo "<tr><td class=\"e\">{$row[0]}</td><td>{$row[1]}</td></tr>";
            }
            echo '</table>';
        }
    }

    private function outputPhpInfo(): void
    {
        // Get phpinfo options from
        $infoType = 'all';

        $this->outputHeader(_t(__CLASS__ . '.PHP_INFO', 'PHP Information'));
        // todo: add comment about parameter like ?info=modules

        if ($this->isCli) {
            echo "Available info types: all, general, credits, configuration, modules, environment, variables, license\n";
            echo "Current type: {$infoType}\n\n";
        }

        // Map string parameters to phpinfo constants
        $infoTypes = [
            'all' => INFO_ALL,
            'general' => INFO_GENERAL,
            'credits' => INFO_CREDITS,
            'configuration' => INFO_CONFIGURATION,
            'modules' => INFO_MODULES,
            'environment' => INFO_ENVIRONMENT,
            'variables' => INFO_VARIABLES,
            'license' => INFO_LICENSE,
        ];

        $phpinfoType = $infoTypes[$infoType] ?? INFO_ALL;

        if ($this->isCli) {
            // Capture phpinfo output and format for CLI
            ob_start();
            phpinfo($phpinfoType);
            $phpinfo = ob_get_clean();

            // Convert HTML to plain text for CLI
            $phpinfo = strip_tags($phpinfo);
            $phpinfo = html_entity_decode($phpinfo);

            echo $phpinfo;
        } else {
            echo phpinfo($phpinfoType);
        }
    }

    private function getEnvironmentMode(): string
    {
        if (Environment::getEnv('SS_ENVIRONMENT_TYPE')) {
            return Environment::getEnv('SS_ENVIRONMENT_TYPE');
        }

        // Fallback to Director's environment detection
        return Director::get_environment_type() ?: 'unknown';
    }

    private function getDatabaseStatus(): string
    {
        try {
            DB::query('SELECT 1');
            $status = '✓ Connected';
            return $this->isCli ? $status : '<span style="color: green;">' . $status . '</span>';
        } catch (Exception $e) {
            $status = '✗ Connection failed: ' . $e->getMessage();
            return $this->isCli ? $status : '<span style="color: red;">' . $status . '</span>';
        }
    }

    private function getDatabaseName(): string
    {
        try {
            $config = DB::getConfig();
            return $config['database'] ?? 'Not available';
        } catch (Exception $e) {
            return 'Not available';
        }
    }

    private function getCacheInfo(): array
    {
        return [
            [_t(__CLASS__ . '.CACHE_METHOD', 'Cache Method'), Environment::getEnv('SS_CACHE_METHOD') ?: 'file'],
            [_t(__CLASS__ . '.TEMPLATE_CACHE', 'Template Cache'), Environment::getEnv('SS_TEMPLATE_CACHE_METHOD') ?: 'file'],
            [_t(__CLASS__ . '.MANIFEST_CACHE', 'Manifest Cache'), Environment::getEnv('SS_MANIFESTCACHE') ?: 'enabled'],
        ];
    }
}
