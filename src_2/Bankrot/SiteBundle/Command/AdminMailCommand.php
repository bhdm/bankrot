<?php
namespace Bankrot\SiteBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AdminMailCommand extends ContainerAwareCommand
{
    protected $sendTo; # doctor # reset #
    protected $subject = 'lotbankrot.ru';
    protected $template = 'BankrotSiteBundle:Mail:admin.html.twig';

    protected function configure()
    {
        $this->setName('send:admin');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        # снимаем ограничение времени выполнения скрипта (в safe-mode не работает)
        set_time_limit(0);

        $templating = $this->getContainer()->get('templating');

        $em           = $this->getContainer()->get('doctrine')->getManager();
        $pdo          = $em->getConnection();

        $users = $em->createQuery('
			SELECT u
			FROM BankrotSiteBundle:User u ')->getResult();


        $msgEntity = $em->createQuery('
			SELECT m
			FROM BankrotSiteBundle:Mail m ORDER BY m.id DESC')->getResult();
//        dump($msgEntity);
        if ($msgEntity){
            $msgEntity = $msgEntity[0];
            $msg = $msgEntity->getBody();
            $em->remove($msgEntity);
            $em->flush($msgEntity);
            # рассылка по 100 пользователям за цикл
            for ($i = 0, $c = count($users); $i < $c; $i++) {
                $html = $templating->render($this->template, array(
                    'msg' => $msg
                ));

                $email = $users[$i]->getEmail();
                $to    = $users[$i]->getUsername();

                $error = $this->send($email, $to, $html, $this->subject);

                $output->writeln('Отправлено: '.$email);

                if ($i && ($i % 100) == 0) {
                    sleep(60);
                }
            }
        }

    }

    public function send($email, $to, $body, $subject, $local = false){
        $subject = "Сообщение с сайта";

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