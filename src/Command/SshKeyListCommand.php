<?php

namespace CommerceGuys\Platform\Cli\Command;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SshKeyListCommand extends PlatformCommand
{

    protected function configure()
    {
        $this
            ->setName('ssh-key:list')
            ->setAliases(array('ssh-keys'))
            ->setDescription('Get a list of all added SSH keys');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $client = $this->getAccountClient();
        $data = $client->getSshKeys();
        $key_rows = array();
        foreach ($data['keys'] as $key) {
            $key_row = array();
            $key_row[] = $key['id'];
            $key_row[] = $key['title'] . ' (' . $key['fingerprint'] . ')';
            $key_rows[] = $key_row;
        }

        $output->writeln("\nYour SSH keys are: ");
        $table = new Table($output);
        $table
            ->setHeaders(array('ID', 'Key'))
            ->addRows($key_rows);
        $table->render();

        $output->writeln("\nAdd a new SSH key by running <info>platform ssh-key:add [path]</info>.");
        $output->writeln("Delete an SSH key by running <info>platform ssh-key:delete [id]</info>.\n");
    }
}
