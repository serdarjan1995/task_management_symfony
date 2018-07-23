<?php

namespace Message\MessageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="Message\MessageBundle\Repository\MessageRepository")
 */
class Message
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
     * @var int
     *
     * @ORM\Column(name="src_user_id", type="integer")
     */
    private $srcUserId;

    /**
     * @var int
     *
     * @ORM\Column(name="dst_user_id", type="integer")
     */
    private $dstUserId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="string", length=255)
     */
    private $content;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_read", type="boolean")
     */
    private $isRead;


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
     * Set srcUserId
     *
     * @param integer $srcUserId
     *
     * @return Message
     */
    public function setSrcUserId($srcUserId)
    {
        $this->srcUserId = $srcUserId;

        return $this;
    }

    /**
     * Get srcUserId
     *
     * @return int
     */
    public function getSrcUserId()
    {
        return $this->srcUserId;
    }

    /**
     * Set dstUserId
     *
     * @param integer $dstUserId
     *
     * @return Message
     */
    public function setDstUserId($dstUserId)
    {
        $this->dstUserId = $dstUserId;

        return $this;
    }

    /**
     * Get dstUserId
     *
     * @return int
     */
    public function getDstUserId()
    {
        return $this->dstUserId;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return Message
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set isRead
     *
     * @param boolean $isRead
     *
     * @return Message
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;

        return $this;
    }

    /**
     * Get isRead
     *
     * @return bool
     */
    public function getIsRead()
    {
        return $this->isRead;
    }
}

