<?php

/**
 * Represents a user object to work with 
 */
class UserEntity
{
    private $display_name;

    private $email;

    private $id;
    
    private $admin;

    /**
     * UserEntity constructor.
     */
    public function __construct()
    {
        $this->display_name = "";
        $this->email = "";
        $this->id = -1;
        $this->admin = false;
    }

    /**
     * @param string $name
     */
    public function setDisplayName(string $name) {
        $this->display_name = $name;
    }

    /**
     * @return string
     */
    public function getDisplayName() {
        return $this->display_name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }
    
    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    
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
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->admin;
    }

    /**
     * @return string JSON representation of this entity
     */
    public function toJson()
    {
        return json_encode(
            array(
                'id' => intval($this->id, 10),
                'email' => $this->email,
                'display_name' => $this->display_name,
                'isAdmin' => $this->admin
            )
        );
    }

}