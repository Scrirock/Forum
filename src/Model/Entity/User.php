<?php

namespace Scrirock\Forum\Model\Entity;

class User{

    private ?int $id;
    private ?string $name;
    private ?string $mail;
    private ?string $password;
    private int $role;

    /**
     * User constructor.
     * @param string|null $name
     * @param string|null $mail
     * @param string|null $password
     * @param int $role
     * @param int|null $id
     */
    public function __construct(string $name = null, string $mail = null, string $password = null, int $role=1, int $id = null){
        $this->id = $id;
        $this->name = $name;
        $this->mail = $mail;
        $this->password = $password;
        $this->role = $role;
    }

    /**
     * Return the user's ID
     * @return int|null
     */
    public function getId(): ?int{
        return $this->id;
    }

    /**
     * Set the user's ID
     * @param int|null $id
     */
    public function setId(?int $id): void{
        $this->id = $id;
    }

    /**
     * Return the user's name
     * @return string
     */
    public function getName(): string{
        return $this->name;
    }

    /**
     * Set the user's name
     * @param string $name
     */
    public function setName(string $name): void{
        $this->name = $name;
    }

    /**
     * Return the user's mail
     * @return string|null
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * Set the user's mail
     * @param string|null $mail
     */
    public function setMail(?string $mail): void
    {
        $this->mail = $mail;
    }

    /**
     * Return the user's password
     * @return string
     */
    public function getPassword(): string{
        return $this->password;
    }

    /**
     * Set the user's password
     * @param string $password
     */
    public function setPassword(string $password): void{
        $this->password = $password;
    }

    /**
     * Return the user's role
     * @return int
     */
    public function getRole(): int{
        return $this->role;
    }

    /**
     * Set the user's role
     * @param int $role
     */
    public function setRole(int $role): void{
        $this->role = $role;
    }

}