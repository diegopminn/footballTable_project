<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * A command console that create a symbolic link for the app assets.
 *
 *     $ php bin/console app:symlink-assets
 */
class CreateAssetsSymbolicLinkCommand extends Command
{
    protected static $defaultName = 'app:symlink-assets';

    private $filesystem;
    private $projectDir;

    public function __construct(Filesystem $filesystem, string $projectDir = null)
    {
        parent::__construct();

        $this->filesystem = $filesystem;
        $this->projectDir = $projectDir;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->filesystem->symlink($this->projectDir.'/assets/app/', 'public/bundles/app');

        return 0;
    }
}
