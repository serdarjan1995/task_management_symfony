<?php

namespace User\UserBundle\Controller;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Security\Csrf\CsrfToken;
use User\UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;



class UserController extends Controller
{


    public function loginAction()
    {
        return $this->render('UserBundle:Default:login.html.twig');
    }

    public function checkUserAction(Request $request)
    {
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        $em = $this->getDoctrine()->getManager();
        $user = $em->createQueryBuilder()
            ->select('u')
            ->from('UserBundle:User', 'u')
            ->where('u.username = :uname')
            ->andWhere('u.password = :pass')
            ->setParameter('uname', $username)
            ->setParameter('pass', $password)
            ->getQuery()
            ->getOneOrNullResult();

        //var_dump($user);
        //exit;

        if($user){
            return $this->render('UserBundle:Default:index.html.twig',
                array('user' => $user));
        }
        else{
            return $this->render('UserBundle:Default:login.html.twig',
                array('message' => 'Username or password incorrect'));
        }

    }

    public function newUserAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $username = $request->request->get('username');
        $user = $em->createQueryBuilder()
            ->select('u')
            ->from('UserBundle:User', 'u')
            ->where('u.username = :uname')
            ->setParameter('uname', $username)
            ->getQuery()
            ->getOneOrNullResult();
        if($user){
            return $this->render('UserBundle:Default:login.html.twig',
                array('message' => 'Username already exist'));
        }
        else{
            $password = $request->request->get('password');
            $name = $request->request->get('name');
            $lastname = $request->request->get('lastname');
            $birthdate = new \DateTime($request->request->get('birthdate'));
            $time = date('Y-m-d H:i:s');
            $lastlogin = new \DateTime($time);
            $time = date('Y-m-d');
            $signupdate = new \DateTime($time);

            $newUser = new User();
            $newUser->setName($name);
            $newUser->setLastname($lastname);
            $newUser->setUsername($username);
            $newUser->setPassword($password);
            $newUser->setLastlogin($lastlogin);
            $newUser->setSignupdate($signupdate);
            if($birthdate){
                $newUser->setBirthdate($birthdate);
            }

            $em->persist($newUser);
            $em->flush();
        }

        return $this->render('UserBundle:Default:index.html.twig',
            array('name' => $newUser->getName(),
                'lastname' => $newUser->getLastname()
            ));

    }

    public function newUserFosAction(Request $request){
        $token = $request->request->get('_csrf_security_token');
        $csrf_token = new CsrfToken('thetea',$token);
        $csrf_valid = $this->get('security.csrf.token_manager')->isTokenValid($csrf_token);
        if(!$csrf_valid){
            exit();
        }

        $user_manager = $this->get('fos_user.user_manager');
        $username = $request->request->get('username');
        $user = $user_manager->findUserByUsername($username);
        if ($user)
        {

            /**
             * Flash Bag Success
             */
            $this->get('session')->getFlashBag()
                ->set('message','Username already exists');

            return $this->render('UserBundle:Default:login.html.twig');

        }


        $em = $this->getDoctrine()->getManager();

        $password = $request->request->get('password');
        $name = $request->request->get('name');
        $lastname = $request->request->get('lastname');
        $email = $request->request->get('email');
        $birthdate = new \DateTime($request->request->get('birthdate'));
        $time = date('Y-m-d H:i:s');
        $lastlogin = new \DateTime($time);
        $time = date('Y-m-d');
        $signupdate = new \DateTime($time);

        $newUser = $user_manager->createUser();
        $conf_token = sha1(uniqid(mt_rand(),true));
        $newUser->setConfirmationToken($conf_token);

        $newUser->setName($name);
        $newUser->setLastname($lastname);
        $newUser->setUsername($username);
        $newUser->setEmail($email);
        $newUser->setPlainPassword($password);
        $newUser->setLastlogin($lastlogin);
        $newUser->setSignupdate($signupdate);
        $newUser->addRole('ROLE_USER');
        //$newUser->setEnabled(1);
        if($birthdate){
            $newUser->setBirthdate($birthdate);
        }

        $mailer = $this->container->get('fos_user.mailer');
        $mailer->sendConfirmationEmailMessage($newUser);
        /*

        $message = (new \Swift_Message('Confirm your email.'))
            ->setFrom(array('enuygun.it.camp@gmail.com' => 'Enuygun.com IT'))
            ->setTo(array('serdarjan@mail.ru' => $newUser->getName().' '.$newUser->getLastname()))
            ->setSubject('Confirmation mail')
            ->setBody(
                $this->renderView(
                    'UserBundle:Default:send-mail.html.twig', array(
                        'user' => $newUser
                    )
                ),
                'text/html'
            );
        $this->get('mailer')->send($message);


        */


        $user_manager->updateUser($newUser);

        $em->flush();



        $this->get('session')->getFlashBag()
            ->set('signup_success','Successful Sign Up');

        $token = new UsernamePasswordToken($newUser, $newUser->getPassword(),
            "public", $newUser->getRoles());

        $this->get("security.token_storage")->setToken($token);

        //return $this->redirect($this->generateUrl('user_homepage'));
        //return $this->redirect($this->generateUrl('user_homepage',array('user' => $newUser)));
        return $this->render('UserBundle:Default:index.html.twig', array('user' => $newUser));

    }

    public function loginUserFosAction(Request $request){
        //$user = /*The user needs to be registered */;#
        // Example of how to obtain an user:
        //->findOneBy(array('username' => "some user name example"));

        /// if there is not any request
        if ($request->request->all() == null) {
            return $this->render('UserBundle:Default:login.html.twig');
        }

        /// get request parameters
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        /// get user entity
        $user_manager = $this->get('fos_user.user_manager');
        $factory = $this->get('security.encoder_factory');
        $user = $user_manager->findUserByUsername($username);

        if (!$user)
        {
            /**
             * Flash Bag User is not defined
             */
            $this->get('session')->getFlashBag()
                ->set('message','Username or Password is not correct');

            return $this->render('UserBundle:Default:login.html.twig');

        }

        /// authenticate user
        $encoder = $factory->getEncoder($user);
        $result = ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) ? true : false;

        if (!$result)
        {
            /**
             * Flash Bag User Password Error
             */
            $this->get('session')->getFlashBag()
                ->set('message','Username or Password is not correct');

            return $this->render('UserBundle:Default:login.html.twig');

        } else {

            /** update user last login */
            $em = $this->getDoctrine()->getManager();
            $time = date('Y-m-d H:i:s');
            $lastlogin = new \DateTime($time);
            $user->setLastlogin($lastlogin);
            $em->flush();

            //Handle getting or creating the user entity likely with a posted form
            // The third parameter "main" can change according to the name of your firewall in security.yml
            $token = new UsernamePasswordToken($user, $user->getPassword(), 'secured_area', $user->getRoles());

            // If the firewall name is not main, then the set value would be instead:
            // $this->get('session')->set('_security_XXXFIREWALLNAMEXXX', serialize($token));
            $this->get('session')->set('secured_area', serialize($token));
            $this->get('security.token_storage')->setToken($token);
            // Fire the login event manually
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);

            /**
             * Now the user is authenticated !!!!
             * Do what you need to do now, like render a view, redirect to route etc.
             */

            if(in_array('ROLE_ADMIN', $user->getRoles())){
                return $this->render('UserBundle:Default:admin.html.twig', array('user' => $user));
            }

            return $this->render('UserBundle:Default:index.html.twig', array('user' => $user));
        }
    }

    public function adminAction(){
        return $this->render('UserBundle:Default:admin.html.twig');
    }

    public function profileAction(){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        return $this->render('UserBundle:Default:profile.html.twig',array('user' => $user));
    }

    public function updateProfileAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();

        $password = $request->request->get('password');
        $name = $request->request->get('name');
        $lastname = $request->request->get('lastname');

        $birthdate = new \DateTime($request->request->get('birthdate'));
        $time = date('Y-m-d');

        $user->setName($name);
        $user->setLastname($lastname);
        if($password){
            $user->setPlainPassword($password);
        }
        if($birthdate){
            $user->setBirthdate($birthdate);
        }

        $em->flush();

        return $this->redirectToRoute('profile');
    }

    public function uploadAvatarAction(Request $request){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $avatar = $request->files->get('profile_photo');
        //$img_tmp_path = $avatar->getRealPath();
        $image_extension = $avatar->guessExtension();
        $imgName = md5(uniqid()).'.'.$image_extension;
        $avatar->move($this->getParameter('uploads_directory'), $imgName);
        $em = $this->getDoctrine()->getManager();
        $user->setProfilePhoto($imgName);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('profile',array('user' => $user));
    }

    public function deleteAvatarAction(){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $avatar = $user->getProfilePhoto();
        $user->setProfilePhoto('');
        $em->persist($user);
        $em->flush();
        $fs = new Filesystem();
        $fs->remove($this->getParameter('uploads_directory').'/'.$avatar);

        return $this->redirectToRoute('profile',array('user' => $user));
    }

    public function showUsersAction(){
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User_Fos')->findAll();
        return $this->render('UserBundle:Users:show-user.html.twig',array('users' => $users));

    }

    public function createUserAction(){
        return $this->render('UserBundle:Users:newUser.html.twig');
    }

    public function newUserFromAdminAction(Request $request){

        $user_manager = $this->get('fos_user.user_manager');
        $username = $request->request->get('username');
        $user = $user_manager->findUserByUsername($username);
        if ($user)
        {

            /**
             * Flash Bag Error
             */
            $this->get('session')->getFlashBag()
                ->set('message','Username already exists');

            return $this->redirectToRoute('create_user');

        }


        $em = $this->getDoctrine()->getManager();

        $password = $request->request->get('password');
        $name = $request->request->get('name');
        $lastname = $request->request->get('lastname');
        $email = $request->request->get('email');
        $birthdate = new \DateTime($request->request->get('birthdate'));
        $time = date('Y-m-d H:i:s');
        $lastlogin = new \DateTime($time);
        $time = date('Y-m-d');
        $signupdate = new \DateTime($time);


        $newUser = $user_manager->createUser();
        $newUser->setName($name);
        $newUser->setLastname($lastname);
        $newUser->setUsername($username);
        $newUser->setEmail($email);
        $newUser->setPlainPassword($password);
        $newUser->setLastlogin($lastlogin);
        $newUser->setSignupdate($signupdate);
        $newUser->addRole('ROLE_USER');
        $newUser->setEnabled(1);
        if($birthdate){
            $newUser->setBirthdate($birthdate);
        }

        $user_manager->updateUser($newUser);

        $em->flush();

        return $this->redirectToRoute('show_users');

    }


    public function deleteUserAction(Request $request){

        $uid = $request->attributes->get('u');
        $em = $this->getDoctrine()->getManager();
        $u = $em->getRepository('UserBundle:User_Fos')->findOneBy(['id' => $uid]);
        $em->remove($u);
        $em->flush();
        return $this->redirectToRoute('show_users');
    }

    public function promoteUserAction(Request $request){
        $uid = $request->attributes->get('u');
        $em = $this->getDoctrine()->getManager();
        $u = $em->getRepository('UserBundle:User_Fos')->findOneBy(['id' => $uid]);
        $u->addRole('ROLE_ADMIN');
        $em->flush();
        return $this->redirectToRoute('show_users');
    }

}
