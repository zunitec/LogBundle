<?php

namespace Zuni\LogBundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zuni\LogBundle\Entity\Log;

/**
 *
 * @author Fábio Lemos Elizandro
 * @Route("/log")
 */
class LogController extends Controller
{

    /**
     * Lista os logs
     *
     * @Route("/{offset}/{limit}", name="log", defaults={"limit" = 10, "offset" = 0})
     * @Method("GET")
     * @Template()
     * @Secure(roles="ROLE_LOG_SHOW")
     */
    public function indexAction($limit = 10, $offset = 0)
    {
        $em = $this->getDoctrine()->getManager("log");

        /* @var $logs Log[] */
        $logs = $em->getRepository("ZuniLogBundle:Log")->findBy(
                array(), array("date" => "DESC", "time" => "DESC"), $limit , $offset
        );

        return array("logs" => $logs);
    }

}
