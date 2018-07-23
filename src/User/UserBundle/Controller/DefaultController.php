<?php

namespace User\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if($user != 'anon.'){
            return $this->render('UserBundle:Default:index.html.twig', array('user' => $user));
        }
        return $this->redirectToRoute('login_user_fos');
    }
}
