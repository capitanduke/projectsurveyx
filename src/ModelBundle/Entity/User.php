<?php

namespace ModelBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;



/**
* @ORM\Entity
* @ORM\Table(name="fos_user")
*/
class User extends BaseUser implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @ORM\ManyToOne(targetEntity="Categoria", inversedBy="user")
    * @ORM\JoinColumn(name="categoria_id", referencedColumnName="id")
    */
    private $categoria;

    /**
    * @var string
    *
    * @ORM\Column(name="path", type="string", length=1000, nullable=true)
    */
    private $path;

    /**
    * @var string
    *
    * @ORM\Column(name="gender", type="string", length=1000, nullable=true)
    */
    private $gender;

    /**
    * @var string
    *
    * @ORM\Column(name="age", type="integer")
    */
    private $age;

    /**
    * @var string
    *
    * @ORM\Column(name="name", type="string", length=1000, nullable=true)
    */
    private $name;

    /**
    * @var string
    *
    * @ORM\Column(name="lastname", type="string", length=1000, nullable=true)
    */
    private $lastname;


    /**
    * One user has many posts. This is the inverse side.
    *  @ORM\OneToMany(targetEntity="Post", mappedBy="user")
    */
    private $posts;
    

    public function __construct() {
        $this->posts = new ArrayCollection();
    }



    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param mixed $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param integer $age
     */
    public function setAge($age)
    {
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get one user has many posts. This is the inverse side.
     */ 
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Set one user has many posts. This is the inverse side.
     *
     * @return  self
     */ 
    public function setPosts($posts)
    {
        $this->posts = $posts;

        return $this;
    }

}
