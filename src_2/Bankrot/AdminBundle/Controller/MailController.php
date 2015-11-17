<?php
namespace Bankrot\AdminBundle\Controller;

use Bankrot\SiteBundle\Entity\Mail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Bankrot\SiteBundle\Entity\Page;
use Bankrot\SiteBundle\Form\PageType;

/**
 * Class PageController
 * @package Bankrot\AdminBundle\Controller
 * @Route("/admin/mail")
 */
class MailController extends Controller
{

    /**
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/", name="admin_mail")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $item = new Mail();
        $form = $this->createFormBuilder($item)
            ->add('body', 'textarea', ['label' => 'Сообщение'])
            ->add('submit', 'submit', ['label' => 'отправить письмо', 'attr' => ['class' => 'btn-primary']])->getForm();
        $formData = $form->handleRequest($request);
        if ($formData->isValid()){
            $item = $formData->getData();
            $em->persist($item);
            $em->flush($item);

            $container = $this->container;
            exec("/bin/ps -axw | awk '{print $1\" \"$5\" \"$6}'", $out);
            foreach ( $out as $val){
                if (preg_match('/mail:admin/', $val)) {
                    $val = explode(' ',$val)[0];
                    exec("/bin/kill -9 $val");
                }
            }
            $cmd = 'php ' . $container->get('kernel')->getRootDir() . '/console mail:send ';
            shell_exec( $cmd . "> /dev/null 2>/dev/null &" );
            $this->redirect($this->generateUrl('admin_mail'));
        }
        return ['form' => $form->createView()];
    }
}