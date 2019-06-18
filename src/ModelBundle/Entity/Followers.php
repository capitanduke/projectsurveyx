<?php

namespace ModelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Followers
 *
 * @ORM\Table(name="followers")
 * @ORM\Entity(repositoryClass="ModelBundle\Repository\FollowersRepository")
 */
class Followers
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
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var int
     *
     * @ORM\Column(name="seguido_id", type="integer")
     */
    private $seguidoId;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set userId.
     *
     * @param int $userId
     *
     * @return Followers
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return Followers
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set seguidoId.
     *
     * @param int $seguidoId
     *
     * @return Followers
     */
    public function setSeguidoId($seguidoId)
    {
        $this->seguidoId = $seguidoId;

        return $this;
    }

    /**
     * Get seguidoId.
     *
     * @return int
     */
    public function getSeguidoId()
    {
        return $this->seguidoId;
    }
}
