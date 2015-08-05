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

    public function sync($output) #Callable $iterationCb = null
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

    public function getFullInfo($output){
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
}
