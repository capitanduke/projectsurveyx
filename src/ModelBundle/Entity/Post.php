<?php

namespace ModelBundle\Entity;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table(name="post")
*/
class Post
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="posts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $userId;


    /**
     * @ORM\OneToMany(targetEntity="Likes", mappedBy="postId")
     */
    private $likes;


    /**
     * @ORM\Column(name="title", type="string")
     */
    private $titlePost;

    /**
     * @ORM\Column(name="post_text", type="string", length=65535)
     */
    private $postText;

    /**
    * @var string
    *
    * @ORM\Column(name="path", type="string", length=1000, nullable=true)
    */
    private $path;


    /**
     * Get the value of userId
     */ 
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */ 
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of postText
     */ 
    public function getPostText()
    {
        return $this->postText;
    }

    /**
     * Set the value of postText
     *
     * @return  self
     */ 
    public function setPostText($postText)
    {
        $this->postText = $postText;

        return $this;
    }
    

    /**
     * Get the value of path
     *
     * @return  string
     */ 
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @param  string  $path
     *
     * @return  self
     */ 
    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get the value of id
     *
     * @return  int
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param  int  $id
     *
     * @return  self
     */ 
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of titlePost
     */ 
    public function getTitlePost()
    {
        return $this->titlePost;
    }

    /**
     * Set the value of titlePost
     *
     * @return  self
     */ 
    public function setTitlePost($titlePost)
    {
        $this->titlePost = $titlePost;

        return $this;
    }

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }


    /**
     * Set Likes
     *
     * @param string $likes
     *
     * @return Likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;

        return $this;
    }

    /**
     * Get Likes
     *
     * @return string
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Add Likes
     *
     *
     * @return Likes
     */
    public function addLikes(Likes $likes)
    {
        $this->likes[] = $likes;

        return $this;
    }

    /**
     * Remove Likes
     *
     */
    public function removeLikes(Likes $likes)
    {
        $this->likes->removeElement($likes);
    }

    
}
