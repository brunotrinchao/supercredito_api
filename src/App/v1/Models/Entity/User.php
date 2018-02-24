<?php

namespace App\v1\Models\Entity;

/**
 * @Entity
 * @Table(name="users")
 */
class User
{
    /**
     * @var integer
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Column(type="string", length=64)
     */
    protected $name;

    /**
     * @var string
     * @Column(type="string", length=255)
     */
    protected $email = [];

	 /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
      /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    /**
     * @return App\Administracao\Models\User
     */
    public function setEmail($email)
    {
        if (!$email && !is_string($email)) {
            throw new \InvalidArgumentException("Nome is required", 400);
        }
        $this->email = $email;
        return $this;
    }
	
	    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @return App\Administracao\Models\User
     */
    public function setName($name)
    {
        if (!$name && !is_string($name)) {
            throw new \InvalidArgumentException("Nome is required", 400);
        }
        $this->name = $name;
        return $this;
    }
    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * @return App\Administracao\Models\User
     */
    public function setPassword($password)
    {
        if (!$name && !is_string($name)) {
            throw new \InvalidArgumentException("Nome is required", 400);
        }
        $this->password = md5($password);
        return $this;
    }

    /**
     * @return App\Administracao\Models\User
     */
    public function getValues() {
        return get_object_vars($this);
    }
}
