<?php

namespace Job\JobBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobType
 *
 * @ORM\Table(name="job_type")
 * @ORM\Entity(repositoryClass="Job\JobBundle\Repository\JobTypeRepository")
 */
class JobType
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
     * @ORM\OneToMany(targetEntity="Job\JobBundle\Entity\Job", mappedBy="jobTypeId")
     */
    private $jobId;

    /**
     * @var string
     *
     * @ORM\Column(name="job_type", type="string", length=255)
     */
    private $jobType;


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
     * Set jobType
     *
     * @param string $jobType
     *
     * @return JobType
     */
    public function setJobType($jobType)
    {
        $this->jobType = $jobType;

        return $this;
    }

    /**
     * Get jobType
     *
     * @return string
     */
    public function getJobType()
    {
        return $this->jobType;
    }

    public function __toString()
    {
        return $this->getJobType();
    }

}
