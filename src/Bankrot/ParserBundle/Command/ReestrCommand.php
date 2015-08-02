<?php

namespace Bankrot\ParserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReestrCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('bankrot:reestr')
            ->setDescription('Синхронизация реестра fedresurs.ru.');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $parser = $this->getContainer()->get('bankrot_parser.reestrparser');

        $output->writeln('<info>Синхронизация началась</info>');
        $parser->sync();
        $output->writeln('<info>Синхронизация завершена</info>');

        $output->writeln('<info>Получение полной информации</info>');
        $parser->getFullInfo();
        $output->writeln('<info>Получение полной информации завершено</info>');
    }
}