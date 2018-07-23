<?php

namespace API\CheckUsernameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('APICheckUsernameBundle:Default:index.html.twig');
    }

    public function checkUsernameAction(Request $request) {

        if($request->request->all() == null){
            return new JsonResponse(array('status' => -1), 403);
        }

        // Post Values
        $username = $request->request->get('username');
        if(strlen($username) > 30 || strlen($username)==0 || strpos($username, ' ') !== false){
            return new JsonResponse(array('status' => -1), 403);
        }

        $user_manager = $this->get('fos_user.user_manager');
        $user = $user_manager->findUserByUsername($username);

        $exists = 0;

        // Control username for existing
        if ($user)
        {
            $exists = 1;
        }

        $result = array(
            'status' => $exists
        );

        return new JsonResponse($result, 200);

    }

    public function checkEmailAction(Request $request) {

        if($request->request->all() == null){
            return new JsonResponse(array('status' => -1), 403);
        }

        // Post Values
        $email = $request->request->get('email');
        if(strlen($email) > 40 || strlen($email)==0 || strpos($email, ' ') !== false){
            return new JsonResponse(array('status' => -1), 403);
        }

        $user_manager = $this->get('fos_user.user_manager');
        $user = $user_manager->findUserBy(array('email' => $email));

        $exists = 0;

        // Control username for existing
        if ($user)
        {
            $exists = 1;
        }

        $result = array(
            'status' => $exists
        );

        return new JsonResponse($result, 200);

    }
}
