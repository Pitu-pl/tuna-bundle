<?php

namespace TheCodeine\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use TheCodeine\NewsBundle\Entity\Category;

class AdminController extends Controller
{
    /**
     *
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
