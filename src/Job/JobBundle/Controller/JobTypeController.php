<?php

namespace Job\JobBundle\Controller;

use Job\JobBundle\Entity\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;


class JobTypeController extends Controller
{
    public function showJobTypeAction(){
        $jobTypes = $this->getDoctrine()->getManager()->getRepository('JobJobBundle:JobType')->findAll();
        return $this->render('JobJobBundle:Default:showJobType.html.twig', array('jobtypes' => $jobTypes));
    }

    public function newJobTypeAction(){
        return $this->render('JobJobBundle:Default:newJobType.html.twig');
    }

    public function addJobTypeAction(Request $request){
        $jobTypeName = $request->request->get('jobtype');
        $jobType = new JobType();
        $jobType->setJobType($jobTypeName);
        $em = $this->getDoctrine()->getManager();
        $em->persist($jobType);
        $em->flush();
        return $this->redirectToRoute('job_type_show');
    }

    public function deleteJobTypeAction(Request $request){
        $jobTypeId = $request->request->get('jobtype');
        $em = $this->getDoctrine()->getManager();
        $jobtype = $em->getRepository('JobJobBundle:JobType')->find($jobTypeId);
        $em->remove($jobtype);
        $em->flush();
        return $this->redirectToRoute('job_type_show');
    }

    public function editJobTypeAction(Request $request){
        $jobTypeId = $request->request->get('jobtype');
        $jobTypes = $this->getDoctrine()->getManager()->getRepository('JobJobBundle:JobType')->find($jobTypeId);
        return $this->render('JobJobBundle:Default:showJobType.html.twig', array('jobtypes' => $jobTypes));
    }

    public function updateJobTypeAction(Request $request){
        $jobTypeId = $request->request->get('jobtype');
        $em = $this->getDoctrine()->getManager();
        $jobtype = $em->getRepository('JobJobBundle:JobType')->find($jobTypeId);
        $em->flush($jobtype);
        return $this->redirectToRoute('job_type_show');
    }
}
