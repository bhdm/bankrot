<?php
namespace Bankrot\SiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class StatusMailCommand extends ContainerAwareCommand
{
    protected $sendTo; # doctor # reset #
    protected $subject = 'Портал';
    protected $template = 'BankrotSiteBundle:Mail:lotStatus.html.twig';

    protected function configure()
    {
        $this->setName('status:mail');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        # снимаем ограничение времени выполнения скрипта (в safe-mode не работает)
        set_time_limit(0);

        $templating = $this->getContainer()->get('templating');

        $em           = $this->getContainer()->get('doctrine')->getManager();
        $pdo          = $em->getConnection();


        # У кого стал зелененький статус
        $date = new \DateTime();
        $date = $date->format('Y-m-d').' 00:00:00';
        $lws = $em->createQuery("
			SELECT lw
			FROM BankrotSiteBundle:LotWatch lw
			WHERE lw.day = '$date'
			")->getResult();

        $output->writeln('Всего '.count($lws).' записей');
        # рассылка по 100 пользователям за цикл
        for ($i = 0, $c = count($lws); $i < $c; $i++) {
            $output->writeln('Запись '.($i+1));
            $lw = $lws[$i];
            $email = $lw->getOwner()->getEmail();
            $to    = $lw->getOwner();
            $html = $templating->render($this->template, array('user' => $lw->getOwner(),'status'=>'Целевой','lot' => $lw->getLot(),'lw' => $lw ));
            $error = $this->send($email, $to, $html, $this->subject);
            if ($i && ($i % 100) == 0) {
                sleep(60);
            }
        }

        # У кого стал желтый статус
        $date = new \DateTime('+5 days');
        $date = $date->format('Y-m-d').' 00:00:00';
        $lws = $em->createQuery("
			SELECT lw
			FROM BankrotSiteBundle:LotWatch lw
			WHERE lw.day = '$date'
			")->getResult();

        $output->writeln('Всего '.count($lws).' записей');
        # рассылка по 100 пользователям за цикл
        for ($i = 0, $c = count($lws); $i < $c; $i++) {
            $output->writeln('Запись '.($i+1));
            $lw = $lws[$i];
            $email = $lw->getOwner()->getEmail();
            $to    = $lw->getOwner();
            $html = $templating->render($this->template, array('user' => $lw->getOwner(),'status'=>'Контрольным','lot' => $lw->getLot(),'lw' => $lw ));
            $error = $this->send($email, $to, $html, $this->subject);
            if ($i && ($i % 100) == 0) {
                sleep(60);
            }
        }

        # У кого стал желтый статус 2
        $date = new \DateTime('+3 days');
        $date = $date->format('Y-m-d').' 00:00:00';
        $lws = $em->createQuery("
			SELECT lw
			FROM BankrotSiteBundle:LotWatch lw
			WHERE lw.day = '$date'
			")->getResult();

        $output->writeln('Всего '.count($lws).' записей');
        # рассылка по 100 пользователям за цикл
        for ($i = 0, $c = count($lws); $i < $c; $i++) {
            $output->writeln('Запись '.($i+1));
            $lw = $lws[$i];
            $email = $lw->getOwner()->getEmail();
            $to    = $lw->getOwner();
            $html = $templating->render($this->template, array('user' => $lw->getOwner(),'status'=>'Контрольным','lot' => $lw->getLot(),'lw' => $lw ));
            $error = $this->send($email, $to, $html, $this->subject);
            if ($i && ($i % 100) == 0) {
                sleep(60);
            }
        }
    }

    public function send($email, $to, $body, $subject, $local = false)
    {

        $subject = "Изменение статуса лота";

        $container        = $this->getContainer();
        $mailer           = $container->get('mailer');
        $mailer_transport = $container->get('swiftmailer.transport.real');
        $transport = $mailer->getTransport();
        $spool     = $transport->getSpool();
        $msg = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setContentType('text/html')
            ->setCharset('utf-8')
            ->setFrom('info@lotbankrot.org', 'lotbankrot.org')
            ->setBody($body)
            ->setTo($email);
        $headers = $msg->getHeaders();
        $headers->addTextHeader('Precedence', 'bulk');
        $headers->addTextHeader('X-Mailru-Msgtype', 'digest_monthly');

        $result = $mailer->send($msg);

        # очищение очереди отправки сообщений
        $spool->flushQueue($mailer_transport);
    }
}