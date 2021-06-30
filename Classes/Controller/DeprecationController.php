<?php

declare(strict_types=1);

namespace CoStack\Logs\Controller;

use TYPO3\CMS\Core\Log\Writer\FileWriter;
use TYPO3\CMS\Core\Messaging\AbstractMessage;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

use function asort;
use function fclose;
use function fgets;
use function fopen;
use function fwrite;
use function rename;
use function sha1;
use function strpos;
use function substr;
use function trim;
use function uniqid;
use function unlink;

class DeprecationController extends ActionController
{
    private const STATIC_PREFIX = 'component="TYPO3.CMS.deprecations":'
    . ' Core: Error handler (BE): TYPO3 Deprecation Notice:';

    public function filterAction(): void
    {
        $file = $this->getLogFilePath();
        $stream = fopen($file, 'rb');

        // Counts and messages are collected separately for easier sorting.
        $deprecations = [];
        $count = [];
        while ($line = fgets($stream)) {
            $line = trim($line);
            $pos = strpos($line, self::STATIC_PREFIX);
            if (false !== $pos) {
                $line = substr($line, $pos + 87);
                $line = trim($line);
            }
            $hash = sha1($line);
            $deprecations[$hash] = $line;
            $count[$hash]++;
        }
        fclose($stream);

        asort($deprecations);

        // Add count to all messages
        foreach ($deprecations as $hash => $message) {
            $deprecations[$hash] = [
                'message' => $message,
                'count' => $count[$hash]
            ];
        }

        $this->view->assign('deprecations', $deprecations);
    }

    /**
     * 1. Create a new log file
     * 2. Copy all lines from the old to the new file which do not match the hash
     * 3. Replace the old file with the new file
     * 4. Profit
     */
    public function deleteAction(string $hash): void
    {
        $file = $this->getLogFilePath();

        $newFile = $file . uniqid('', true);
        $newStream = fopen($newFile, 'xb');
        if (false === $newStream) {
            $this->addFlashMessage(
                LocalizationUtility::translate('error.log_file_not_writable', 'logs'),
                LocalizationUtility::translate('error', 'logs'),
                AbstractMessage::ERROR
            );
            $this->redirect('filter');
        }
        $oldStream = fopen($file, 'rb');

        $count = 0;
        while ($line = fgets($oldStream)) {
            if (empty($line)) {
                continue;
            }
            $probe = trim($line);
            $pos = strpos($probe, self::STATIC_PREFIX);
            if (false !== $pos) {
                $probe = substr($probe, $pos + 87);
                $probe = trim($probe);
            }
            if (sha1($probe) === $hash) {
                $count++;
                continue;
            }
            fwrite($newStream, $line);
        }

        fclose($newStream);
        fclose($oldStream);

        unlink($file);
        rename($newFile, $file);

        $this->addFlashMessage(LocalizationUtility::translate('deleted_count', 'logs', [$count]));

        $this->redirect('filter');
    }

    protected function getLogFilePath(): string
    {
        $writer = new FileWriter(['logFileInfix' => 'deprecations']);
        return $writer->getLogFile();
    }
}
