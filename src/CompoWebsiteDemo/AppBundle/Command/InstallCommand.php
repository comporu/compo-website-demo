<?php

/*
 * This file is part of the CompoSymfonyCms package.
 * (c) Compo.ru <info@compo.ru>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CompoWebsiteDemo\AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class InstallCommand.
 */
class InstallCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setName('compo:webiste-demo:install')
            ->setDescription('compo:webiste-demo:install');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $application = $this->getApplication();
        $container = $this->getContainer();
        $kernel = $container->get('kernel');
        $rootDir = $kernel->getRootDir();
        $projectDir = \dirname($rootDir);

        $application->find('doctrine:database:drop')->run(
            new ArrayInput(
                [
                    '--env' => 'dev',
                    '--verbose' => true,
                    '--no-debug' => true,
                    '--force' => true,
                ]
            ),
            $output
        );

        $application->find('doctrine:database:create')->run(
            new ArrayInput(
                [
                    '--env' => 'dev',
                    '--verbose' => true,
                    '--no-debug' => true,
                    '--if-not-exists' => true,
                ]
            ),
            $output
        );

        $application->find('doctrine:schema:update')->run(
            new ArrayInput(
                [
                    '--env' => 'dev',
                    '--verbose' => true,
                    '--no-debug' => true,
                    '--force' => true,
                    '--dump-sql' => false,
                ]
            ),
            $output
        );

        $application->find('fos:user:create')->run(
            new ArrayInput(
                [
                    '--env' => 'dev',
                    '--verbose' => true,
                    '--no-debug' => true,
                    '--super-admin' => true,
                    'username' => 'admin',
                    'email' => $this->getFaker()->safeEmail,
                    'password' => 'admin',
                ]
            ),
            $output
        );

        $application->find('sonata:page:create-site')->run(
            new ArrayInput(
                [
                    '--env' => 'dev',
                    '--verbose' => true,
                    '--no-debug' => true,
                    '--enabled' => true,
                    '--name' => 'WebSiteDemo',
                    '--locale' => '-',
                    '--host' => 'localhost',
                    '--relativePath' => '/',
                    '--enabledFrom' => 'now',
                    '--enabledTo' => '+10 years',
                    '--default' => 'true',
                    '--no-interaction' => 'true',
                    '--no-confirmation' => 'true',
                ]
            ),
            $output
        );

        $process = new Process('bin/console sonata:page:update-core-routes --env=dev --verbose --no-debug --site=all');
        $process->setWorkingDirectory($projectDir);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output->writeln($process->getOutput());

        $process = new Process('bin/console sonata:page:create-snapshots --env=dev --verbose --no-debug --site=all');
        $process->setWorkingDirectory($projectDir);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $application->find('doctrine:fixtures:load')->run(
            new ArrayInput(
                [
                    '--env' => 'dev',
                    '--verbose' => true,
                    '--no-debug' => true,
                    '--append' => true,
                ]
            ),
            $output
        );

        $process = new Process('bin/console sonata:page:update-core-routes --env=dev --verbose --no-debug --site=all');
        $process->setWorkingDirectory($projectDir);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output->writeln($process->getOutput());

        $process = new Process('bin/console sonata:page:create-snapshots --env=dev --verbose --no-debug --site=all');
        $process->setWorkingDirectory($projectDir);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output->writeln($process->getOutput());

        $process = new Process('bin/console compo:seo:page:load --env=dev --verbose --no-debug');
        $process->setWorkingDirectory($projectDir);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output->writeln($process->getOutput());

        $process = new Process('bin/console sonata:cache:flush-all --env=dev --verbose --no-debug');
        $process->setWorkingDirectory($projectDir);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output->writeln($process->getOutput());
    }

    /**
     * @return \Faker\Generator|object
     */
    public function getFaker()
    {
        return $this->getContainer()->get('faker.generator');
    }
}
