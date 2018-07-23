<?php

namespace Job\JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Job
 *
 * @ORM\Table(name="job")
 * @ORM\Entity(repositoryClass="Job\JobBundle\Repository\JobRepository")
 */
class Job
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="assign_date", type="datetime")
     */
    private $assignDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadline", type="datetime")
     */
    private $deadline;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User\UserBundle\Entity\User_Fos", inversedBy="assignerId")
     * @ORM\JoinColumn(name="assigned_user_id", referencedColumnName="id")
     */
    private $assignedUserId;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="User\UserBundle\Entity\User_Fos", inversedBy="referrerId")
     * @ORM\JoinColumn(name="referrer_user_id", referencedColumnName="id")
     */
    private $referrerUserId;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="Job\JobBundle\Entity\JobType", inversedBy="jobId")
     * @ORM\JoinColumn(name="job_type_id", referencedColumnName="id")
     */
    private $jobTypeId;

    /**
     * @var string
     *
     * @ORM\Column(name="job_status", type="string", length=255, nullable=true)
     */
    private $jobStatus;

    /**
     * @var text
     *
     * @ORM\Column(name="job_desc", type="text", nullable=true)
     */
    private $jobDescription;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set assignDate
     *
     * @param \DateTime $assignDate
     *
     * @return Job
     */
    public function setAssignDate($assignDate)
    {
        $this->assignDate = $assignDate;

        return $this;
    }

    /**
     * Get assignDate
     *
     * @return \DateTime
     */
    public function getAssignDate()
    {
        return $this->assignDate;
    }

    /**
     * Set deadline
     *
     * @param \DateTime $deadline
     *
     * @return Job
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;

        return $this;
    }

    /**
     * Get deadline
     *
     * @return \DateTime
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set assignedUserId
     *
     * @param integer $assignedUserId
     *
     * @return Job
     */
    public function setAssignedUserId($assignedUserId)
    {
        $this->assignedUserId = $assignedUserId;

        return $this;
    }

    /**
     * Get assignedUserId
     *
     * @return int
     */
    public function getAssignedUserId()
    {
        return $this->assignedUserId;
    }

    /**
     * Set referrerUserId
     *
     * @param integer $referrerUserId
     *
     * @return Job
     */
    public function setReferrerUserId($referrerUserId)
    {
        $this->referrerUserId = $referrerUserId;

        return $this;
    }

    /**
     * Get referrerUserId
     *
     * @return int
     */
    public function getReferrerUserId()
    {
        return $this->referrerUserId;
    }

    /**
     * Set jobTypeId
     *
     * @param integer $jobTypeId
     *
     * @return Job
     */
    public function setJobTypeId($jobTypeId)
    {
        $this->jobTypeId = $jobTypeId;

        return $this;
    }

    /**
     * Get jobTypeId
     *
     * @return int
     */
    public function getJobTypeId()
    {
        return $this->jobTypeId;
    }

    /**
     * Set jobStatus
     *
     * @param string $jobStatus
     *
     * @return Job
     */
    public function setJobStatus($jobStatus)
    {
        $this->jobStatus = $jobStatus;

        return $this;
    }

    /**
     * Get jobStatus
     *
     * @return string
     */
    public function getJobStatus()
    {
        return $this->jobStatus;
    }

    /**
     * Set jobDescription
     *
     * @param string $jobDescription
     *
     * @return JobType
     */
    public function setJobDescription($jobDescription)
    {
        $this->jobDescription = $jobDescription;

        return $this;
    }

    /**
     * Get jobDescription
     *
     * @return string
     */
    public function getJobDescription()
    {
        return $this->jobDescription;
    }

}
