<?php

namespace Job\JobBundle\Controller;

use Job\JobBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JobJobBundle:Default:index.html.twig');
    }


    public function newJobAction(){
        $em = $this->getDoctrine()->getManager();
        $jobtypes = $em->getRepository('JobJobBundle:JobType')->findAll();
        $users = $em->getRepository('UserBundle:User_Fos')->findAll();

        return $this->render('JobJobBundle:Default:newJob.html.twig',
            array( 'jobtypes' => $jobtypes,
                'users' => $users
            ));
    }

    public function assignAction(Request $request){

        /**
            Get Post params
         */
        $assignedUserid = $request->request->get('user');
        $jobtypeid = $request->request->get('jobtype');
        $jobDesc = $request->request->get('job_desc');
        $date = $request->request->get('deadline_date');
        $time = $request->request->get('deadline_time');
        $datetime =$date.' '.$time;


        $em = $this->getDoctrine()->getManager();


        /** get current logged in user */
        $referrer = $this->get('security.token_storage')->getToken()->getUser();

        /** Find assignedUser by id */
        $assignedUser = $em->getRepository('UserBundle:User_Fos')->find($assignedUserid);

        /** Find assignedUser by id */
        $jobtype = $em->getRepository('JobJobBundle:JobType')->find($jobtypeid);


        $newJob = new Job();
        $newJob->setAssignDate(new \DateTime(date('Y-m-d H:i:s')));
        $newJob->setAssignedUserId($assignedUser);
        $newJob->setDeadline(new \DateTime($datetime));
        $newJob->setJobStatus('new assigned');
        $newJob->setJobTypeId($jobtype);
        $newJob->setJobDescription($jobDesc);
        $newJob->setReferrerUserId($referrer);
        $em->persist($newJob);
        $em->flush();

        /*$param = array('assigned' => $assignedUser,
            'jobtype' => $jobtype,
            'datetime' => $datetime,
            'referrer' => $referrer);


        return $this->render('JobJobBundle:Default:index.html.twig',$param);
        */
        return $this->redirectToRoute('job_show');
    }


    public function displayAction(){

        $em = $this->getDoctrine()->getManager();


        $jobs = $em->getRepository('JobJobBundle:Job')->findAll();


        return $this->render('JobJobBundle:Default:index.html.twig',array('jobs' => $jobs));

    }

    public function deleteJobAction(Request $request){

        $jobId = $request->attributes->get('job');
        $em = $this->getDoctrine()->getManager();
        $job = $em->getRepository('JobJobBundle:Job')->findOneBy(['id' => $jobId]);
        $em->remove($job);
        $em->flush();
        return $this->redirectToRoute('job_show');
    }

    public function editJobAction(Request $request){

        $jobId = $request->attributes->get('job');
        $em = $this->getDoctrine()->getManager();
        $job = $em->getRepository('JobJobBundle:Job')->findOneBy(['id' => $jobId]);
        $jobtypes = $em->getRepository('JobJobBundle:JobType')->findAll();
        $users = $em->getRepository('UserBundle:User_Fos')->findAll();

        return $this->render('JobJobBundle:Default:editJob.html.twig',
            array( 'jobtypes' => $jobtypes,
                'users' => $users,
                'job' => $job
            ));
    }

    public function updateJobAction(Request $request){

        $jobId = $request->attributes->get('job');
        $em = $this->getDoctrine()->getManager();
        $job = $em->getRepository('JobJobBundle:Job')->findOneBy(['id' => $jobId]);

        $assignedUserid = $request->request->get('user');
        $jobtypeid = $request->request->get('jobtype');
        $jobDesc = $request->request->get('job_desc');
        $status = $request->request->get('status');
        $date = $request->request->get('deadline_date');
        $time = $request->request->get('deadline_time');
        $datetime =$date.' '.$time;

        /** get current logged in user */
        $referrer = $this->get('security.token_storage')->getToken()->getUser();

        /** Find assignedUser by id */
        $assignedUser = $em->getRepository('UserBundle:User_Fos')->find($assignedUserid);

        /** Find assignedUser by id */
        $jobtype = $em->getRepository('JobJobBundle:JobType')->find($jobtypeid);


        $job->setAssignDate(new \DateTime(date('Y-m-d H:i:s')));
        $job->setAssignedUserId($assignedUser);
        $job->setDeadline(new \DateTime($datetime));
        $job->setJobStatus($status);
        $job->setJobTypeId($jobtype);
        $job->setJobDescription($jobDesc);
        $job->setReferrerUserId($referrer);
        $em->persist($job);
        $em->flush();

        return $this->redirectToRoute('job_show');

    }

}
