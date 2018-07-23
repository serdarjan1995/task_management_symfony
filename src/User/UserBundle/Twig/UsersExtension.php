<?php
/**
 * Created by PhpStorm.
 * User: sardor
 * Date: 13.07.2018
 * Time: 11:12
 */

namespace User\UserBundle\Twig;


use Symfony\Bridge\Doctrine\RegistryInterface;

class UsersExtension extends \Twig_Extension
{


    protected $doctrine;

    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    public function getName()
    {
        return 'users_extension';
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('user_count', array($this, 'countUsers')),
            new \Twig_SimpleFunction('job_count', array($this, 'countJobs'))
        );
    }

    public function countUsers()
    {
        $em = $this->doctrine->getManager();

        $qb = $em->createQueryBuilder()
            ->select('count(u.id) AS total_users')
            ->from('UserBundle:User_Fos', 'u')
            ->getQuery()
            ->getOneOrNullResult();

        $usersCount = $qb['total_users'];

        return $usersCount;
    }

    public function countJobs()
    {
        $em = $this->doctrine->getManager();

        $qb = $em->createQueryBuilder()
            ->select('count(j.id) AS total_jobs')
            ->from('JobJobBundle:Job', 'j')
            ->getQuery()
            ->getOneOrNullResult();

        $usersCount = $qb['total_jobs'];

        return $usersCount;
    }
}