<?php

namespace CommerceGuys\Platform\Cli\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EnvironmentUrlCommand extends UrlCommandBase
{

    protected function configure()
    {
        parent::configure();
        $this
            ->setName('environment:url')
            ->setAliases(array('url'))
            ->setDescription('Get the public URL of an environment')
            ->addArgument(
                'path',
                InputArgument::OPTIONAL,
                'A path to append to the URL.'
            );
        $this->addProjectOption()->addEnvironmentOption();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->validateInput($input, $output)) {
            return;
        }

        if (empty($this->environment['_links']['public-url']['href'])) {
            throw new \Exception('No URL available');
        }

        $url = $this->environment['_links']['public-url']['href'];

        $path = $input->getArgument('path');
        if ($path) {
            $url .= trim($path);
        }

        $this->openUrl($url, $input, $output);
    }
}
