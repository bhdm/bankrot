<?php

namespace Bankrot\ParserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ReestrCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('bankrot:reestr')
            ->setDescription('Синхронизация реестра fedresurs.ru.')
            ->addOption('type',null,InputOption::VALUE_REQUIRED,'Тип парсера 0-7');

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $parser = $this->getContainer()->get('bankrot_parser.reestrparser');

        $type = $input->getOption('type');

        if ($type == 1){
            $output->writeln('<info>Синхронизация началась</info>');
            $parser->syncA($output);
            $output->writeln('<info>Синхронизация завершена</info>');

            $output->writeln('<info>Получение полной информации</info>');
            $parser->getFullInfoA($output);
            $output->writeln('<info>Получение полной информации завершено</info>');
        }
        if ($type == 2){
            $output->writeln('<info>Синхронизация началась</info>');
            $parser->syncB($output);
            $output->writeln('<info>Синхронизация завершена</info>');

            $output->writeln('<info>Получение полной информации</info>');
            $parser->getFullInfoB($output);
            $output->writeln('<info>Получение полной информации завершено</info>');
        }
        if ($type == 3){
            $output->writeln('<info>Синхронизация началась C</info>');
            $parser->syncC($output);
            $output->writeln('<info>Синхронизация завершена C</info>');
        }
        if ($type == 4){
            $output->writeln('<info>Синхронизация началась</info>');
            $parser->syncD($output);
            $output->writeln('<info>Синхронизация завершена</info>');

            $output->writeln('<info>Получение полной информации</info>');
            $parser->getFullInfoD($output);
            $output->writeln('<info>Получение полной информации завершено</info>');
        }

        if ($type == 5){
            $output->writeln('<info>Синхронизация началась</info>');
            $parser->syncE($output);
            $output->writeln('<info>Синхронизация завершена</info>');

            $output->writeln('<info>Получение полной информации</info>');
            $parser->getFullInfoE($output);
            $output->writeln('<info>Получение полной информации завершено</info>');
        }

        if ($type == 7){
            $output->writeln('<info>Синхронизация началась</info>');
            $parser->syncG($output);
            $output->writeln('<info>Синхронизация завершена</info>');
        }
    }
}