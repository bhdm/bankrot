<?php

namespace Bankrot\ParserBundle\Parser;

use Bankrot\ParserBundle\Entity\Area;
use Bankrot\ParserBundle\Entity\Debtor;
use Bankrot\ParserBundle\Entity\Lot;
use Bankrot\ParserBundle\Entity\PriceType;
use Bankrot\ParserBundle\Entity\Status;
use Bankrot\ParserBundle\Entity\Type;
use Bankrot\SiteBundle\Entity\Reestr;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;
use Liuggio\ExcelBundle\LiuggioExcelBundle;

class ReestrParser
{
    /** @var EntityManager $em */
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function syncA($output)
    {
        $fileName = '/var/www/blog/web/parsA.xls'; # Файл будет лежать в папке WEB и называться parsA.xls
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $excel = $objReader->load($fileName);

        #######################
        # Парсер по должникам #
        #######################
        for ($i = 1 ; $i <= 1981 ; $i++){
//            if ($excel->setActiveSheetIndex(0)->getCell('B'.$i) == ''){
//                $output->writeln('Выход');
//                break;
//            }
            $category = $excel->setActiveSheetIndex(0)->getCell('A'.$i);
            $fullName = $excel->setActiveSheetIndex(0)->getCell('B'.$i);
            $inn = $excel->setActiveSheetIndex(0)->getCell('C'.$i);
            $ogrn = $excel->setActiveSheetIndex(0)->getCell('D'.$i);
            $region = $excel->setActiveSheetIndex(0)->getCell('E'.$i);
            $adrs = $excel->setActiveSheetIndex(0)->getCell('F'.$i);
            $link = $excel->setActiveSheetIndex(0)->getCell('B'.$i)->getHyperlink()->getUrl();

            $reestr = $this->em->getRepository('BankrotSiteBundle:Reestr')->findBy(array(
                'aFullTitle' => $fullName,
                'aInn' => $inn,
                'link' => $link
            ));
            if ($reestr == null){
                $reestr = new Reestr();
                $reestr->setCategory(0);
                $reestr->setAFullTitle($fullName);
                $reestr->setAInn($inn);
                $reestr->setAOgrn($ogrn);
                $reestr->setAAdrs($adrs);
                $reestr->setARegion($region);
                $reestr->setLink($link);
                $reestr->setASubCategory($category);
                $reestr->setPars(0);
                $this->em->persist($reestr);
                $this->em->flush($reestr);
                $output->writeln($link);
            }
        }
    }

    public function getFullInfoA($output){
        $reestrs = $this->em->getRepository('BankrotSiteBundle:Reestr')->findByPars(0);
        foreach($reestrs as $k => $reestr){
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $reestr->getLink());
            curl_setopt($ch, CURLOPT_USERAGENT, UserAgentGenerator::get());
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $r = iconv('utf8', 'cp1251', curl_exec($ch));

            curl_close($ch);

            (new Crawler($r))
                ->filter('#ctl00_cphBody_trShortName td')
                ->last()
                ->reduce(
                    function (Crawler $sets, $i) use (& $reestr) {
                        $str = $sets->html();
                        $td = trim(strip_tags($str));
                        if ($td) {
                            $reestr->setAShotTitle($td);
                        }
                    }
                );
            (new Crawler($r))
                ->filter('#ctl00_cphBody_trOkopf td')
                ->last()
                ->reduce(
                    function (Crawler $sets, $i) use (& $reestr) {
                        $str = $sets->html();
                        $td = trim(strip_tags($str));
                        if ($td) {
                            $reestr->setAForma($td);
                        }
                    }
                );

            $reestr->setPars(1);
            $this->em->flush();
            $output->writeln($k);
        }
    }

    public function syncB($output)
    {
        $fileName = '/var/www/blog/web/parsB.xls'; # Файл будет лежать в папке WEB и называться parsA.xls
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $excel = $objReader->load($fileName);

        #################
        # Парсер по СРО #
        #################
        for ($i = 1; $i <= 100; $i++) {
            if ($excel->setActiveSheetIndex(0)->getCell('B'.$i) == ''){
                $output->writeln('Выход');
                break;
            }
            $number = $excel->setActiveSheetIndex(0)->getCell('A' . $i);
            $title = $excel->setActiveSheetIndex(0)->getCell('B' . $i);
            $count = $excel->setActiveSheetIndex(0)->getCell('C' . $i);
            $link = $excel->setActiveSheetIndex(0)->getCell('B' . $i)->getHyperlink()->getUrl();
            $reestr = $this->em->getRepository('BankrotSiteBundle:Reestr')->findBy(array(
                'bTitle' => $title,
                'bNumber' => $number,
                'link' => $link
            ));
            if ($reestr == null) {
                $reestr = new Reestr();
                $reestr->setLink($link);
                $reestr->setCategory(1);
                $reestr->setBTitle($title);
                $reestr->setBNumber($number);
                $reestr->setBCountManager($count);
                $reestr->setPars(0);
                $this->em->persist($reestr);
                $this->em->flush($reestr);
                $output->writeln($link);
            }
        }
    }

    public function getFullInfoB($output){
        $reestrs = $this->em->getRepository('BankrotSiteBundle:Reestr')->findByCategory(1);
        foreach($reestrs as $k => $reestr){
            if ($reestr->getPars() == 0){
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $reestr->getLink());
                curl_setopt($ch, CURLOPT_USERAGENT, UserAgentGenerator::get());
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $r = iconv('utf8', 'cp1251', curl_exec($ch));

                curl_close($ch);

//                (new Crawler($r))
//                    ->filter('#ctl00_cphBody_trName td')
//                    ->last()
//                    ->reduce(
//                        function (Crawler $sets, $i) use (& $reestr) {
//                            $str = $sets->html();
//                            $td = trim(strip_tags($str));
//                            if ($td) {
//                                $reestr->setBRegisterDate($td);
//                            }
//                        }
//                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trInn td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setBInn($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trUrAddressSRO td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setBAdrsCpo($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trUrAddressRos td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setBAdrsReestr($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trPostAddress td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setBAdrsMail($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trPhone td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setBPhone($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trEmail td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setBEmail($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trUrl td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setBSite($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trCompFundSizeSRO td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setBSizeFondCpo($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trCompFundRefreshDate td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $date = (explode('.',$td));
                                $date = new \DateTime($date[2].'-'.$date[1].'-'.$date[0]);
                                $reestr->setBDateFondCpo($date);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trCompFundSizeRos td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setBSizeFondReestr($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trFirstManager td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setBManager($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trContactManager td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setBContact($td);
                            }
                        }
                    );
                $reestr->setPars(1);
//                var_dump($reestr);
//                exit;
                $this->em->flush();
                $output->writeln($k);
            }
        }
    }

    public function syncC($output)
    {
        $fileName = '/var/www/blog/web/parsC.xls'; # Файл будет лежать в папке WEB и называться parsA.xls
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $excel = $objReader->load($fileName);

        ############
        # Парсер C #
        ############
        for ($i = 2; $i <= 7667; $i++) {

            $output->writeln($i);
            $reestr = null;
            if ($reestr == null) {
                $output->write('.');
                $reestr = new Reestr();
                $output->write('.');
                $reestr->setCategory(2);
                $output->write('.');
                $reestr->setCLastName($excel->setActiveSheetIndex(0)->getCell('A' . $i)->getValue());
                $output->write('.');
                $reestr->setCFirstName($excel->setActiveSheetIndex(0)->getCell('B' . $i)->getValue());
                $output->write('.');
                $reestr->setCSurName($excel->setActiveSheetIndex(0)->getCell('C' . $i)->getValue());
                $output->write('.');
                $reestr->setCCpo($excel->setActiveSheetIndex(0)->getCell('F' . $i)->getValue());
                $output->write('.');
                $d = new \DateTime();
                $date = $excel->setActiveSheetIndex(0)->getCell('H' . $i)->getValue();
                $date = \PHPExcel_Shared_Date::ExcelToPHP($date);
                $d->setTimestamp($date);
                $output->write('.');
                $reestr->setCDate($d);
                $output->write('.');
                $reestr->setCInn(null);
                $output->write('.');
                $reestr->setCNumber($excel->setActiveSheetIndex(0)->getCell('E' . $i)->getValue());
                $output->write('.');
                $reestr->setCRegion($excel->setActiveSheetIndex(0)->getCell('D' . $i)->getValue());
                $output->write('.');
//                var_dump($reestr);
//                exit;
                $output->write($reestr->getCLastName());
                $reestr->setPars(0);
                $output->write('.');
                $this->em->persist($reestr);
                $output->write('.');
                $this->em->flush($reestr);
                $output->writeLn('!');
            }
        }
    }

    public function syncD($output)
    {
        $fileName = '/var/www/blog/web/ParsD.xls'; # Файл будет лежать в папке WEB и называться parsA.xls
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $excel = $objReader->load($fileName);

        #######################
        # Парсер D #
        #######################
        for ($i = 1; $i <= 5000; $i++) {
            if ($excel->setActiveSheetIndex(0)->getCell('B'.$i) == ''){
                $output->writeln('Выход');
                break;
            }
            $title = $excel->setActiveSheetIndex(0)->getCell('A' . $i);
            $region = $excel->setActiveSheetIndex(0)->getCell('B' . $i);
            $adrs = $excel->setActiveSheetIndex(0)->getCell('C' . $i);
            $link = $excel->setActiveSheetIndex(0)->getCell('A' . $i)->getHyperlink()->getUrl();
            $reestr = $this->em->getRepository('BankrotSiteBundle:Reestr')->findBy(array(
                'dFullTitle' => $title,
                'dInn' => $region,
                'link' => $link
            ));
            if ($reestr == null) {
                $reestr = new Reestr();
                $reestr->setCategory(3);
                $reestr->setDFullTitle($title);
                $reestr->setDRegion($region);
                $reestr->setLink($link);
                $reestr->setDAdrs($adrs);
                $reestr->setPars(0);
                $this->em->persist($reestr);
                $this->em->flush($reestr);
                $output->writeln($link);
            }
        }
    }

    public function getFullInfoD($output){
        $reestrs = $this->em->getRepository('BankrotSiteBundle:Reestr')->findByCategory(3);
        foreach($reestrs as $k => $reestr){
            if ($reestr->getPars() == 0){
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $reestr->getLink());
                curl_setopt($ch, CURLOPT_USERAGENT, UserAgentGenerator::get());
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $r = iconv('utf8', 'cp1251', curl_exec($ch));

                curl_close($ch);

                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trShortName td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setDShotTitle($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trPhone td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setDPhone($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trINN td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setDInn($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trKPP td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setDKpp($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trOGRN td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setDOgrn($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trOKPO td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setDOkpo($td);
                            }
                        }
                    );

                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trOkopf td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setDForma($td);
                            }
                        }
                    );

                $reestr->setPars(1);
                $this->em->flush();
                $output->writeln($k);
            }
        }
    }

    public function syncE($output)
    {
        $fileName = '/var/www/blog/web/parsE.xls'; # Файл будет лежать в папке WEB и называться parsA.xls
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $excel = $objReader->load($fileName);

        for ($i = 1; $i <= 100; $i++) {
            if ($excel->setActiveSheetIndex(0)->getCell('B'.$i) == ''){
                $output->writeln('Выход');
                break;
            }
            $title = $excel->setActiveSheetIndex(0)->getCell('C' . $i)->getValue();
            $title2 = $excel->setActiveSheetIndex(0)->getCell('A' . $i)->getValue();
            $site = $excel->setActiveSheetIndex(0)->getCell('B' . $i)->getValue();
            $link = $excel->setActiveSheetIndex(0)->getCell('A' . $i)->getHyperlink()->getUrl();
            $reestr = $this->em->getRepository('BankrotSiteBundle:Reestr')->findBy(array(
                'eFullTitle' => $title,
                'eTitle' => $title2,
                'link' => $link
            ));
            if ($reestr == null) {
                $reestr = new Reestr();
                $reestr->setCategory(4);
                $reestr->setEFullTitle($title);
                $reestr->setETitle($title2);
                $reestr->setESite($site);
                $reestr->setPars(0);
                $reestr->setLink($link);
                $this->em->persist($reestr);
                $this->em->flush($reestr);
                $output->writeln($link);
            }
        }
    }

    public function getFullInfoE($output){
        $reestrs = $this->em->getRepository('BankrotSiteBundle:Reestr')->findByCategory(4);
        foreach($reestrs as $k => $reestr){
            if ($reestr->getPars() == 0){
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $reestr->getLink());
                curl_setopt($ch, CURLOPT_USERAGENT, UserAgentGenerator::get());
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $r = iconv('utf8', 'cp1251', curl_exec($ch));

                curl_close($ch);

                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trAddress td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setEAdrs($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trInn td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setEInn($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trOgrn td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setEOgrn($td);
                            }
                        }
                    );

                $reestr->setPars(1);
                $this->em->flush();
                $output->writeln($k);
            }
        }
    }

    public function syncF($output)
    {
        $fileName = '/var/www/blog/web/parsE.xls'; # Файл будет лежать в папке WEB и называться parsA.xls
        $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        $excel = $objReader->load($fileName);

        for ($i = 1; $i <= 100; $i++) {
            if ($excel->setActiveSheetIndex(0)->getCell('B'.$i) == ''){
                $output->writeln('Выход');
                break;
            }
            $title = $excel->setActiveSheetIndex(0)->getCell('C' . $i)->getValue();
            $title2 = $excel->setActiveSheetIndex(0)->getCell('A' . $i)->getValue();
            $site = $excel->setActiveSheetIndex(0)->getCell('B' . $i)->getValue();
            $link = $excel->setActiveSheetIndex(0)->getCell('A' . $i)->getHyperlink()->getUrl();
            $reestr = $this->em->getRepository('BankrotSiteBundle:Reestr')->findBy(array(
                'eFullTitle' => $title,
                'eTitle' => $title2,
                'link' => $link
            ));
            if ($reestr == null) {
                $reestr = new Reestr();
                $reestr->setCategory(5);
                $reestr->setEFullTitle($title);
                $reestr->setETitle($title2);
                $reestr->setESite($site);
                $reestr->setPars(0);
                $reestr->setLink($link);
                $this->em->persist($reestr);
                $this->em->flush($reestr);
                $output->writeln($link);
            }
        }
    }

    public function getFullInfoF($output){
        $reestrs = $this->em->getRepository('BankrotSiteBundle:Reestr')->findByCategory(5);
        foreach($reestrs as $k => $reestr){
            if ($reestr->getPars() == 0){
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $reestr->getLink());
                curl_setopt($ch, CURLOPT_USERAGENT, UserAgentGenerator::get());
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $r = iconv('utf8', 'cp1251', curl_exec($ch));

                curl_close($ch);

                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trAddress td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setEAdrs($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trInn td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setEInn($td);
                            }
                        }
                    );
                (new Crawler($r))
                    ->filter('#ctl00_cphBody_trOgrn td')
                    ->last()
                    ->reduce(
                        function (Crawler $sets, $i) use (& $reestr) {
                            $str = $sets->html();
                            $td = trim(strip_tags($str));
                            if ($td) {
                                $reestr->setEOgrn($td);
                            }
                        }
                    );

                $reestr->setPars(1);
                $this->em->flush();
                $output->writeln($k);
            }
        }
    }
}
