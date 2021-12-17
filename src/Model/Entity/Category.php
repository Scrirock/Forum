<?php


namespace Scrirock\Forum\Model\Entity;


class Category{

    private ?int $id;
    private ?string $name;

    /**
     * Category constructor.
     * @param int|null $id
     * @param string|null $name
     */
    public function __construct(?int $id=null, ?string $name=null){
        $this->id = $id;
        $this->name = $name;
    }


    /**
     * Return the category's id
     * @return int|null
     */
    public function getId(): ?int{
        return $this->id;
    }

    /**
     * Set the category's id
     * @param int|null $id
     */
    public function setId(?int $id): void{
        $this->id = $id;
    }

    /**
     * Return the category's name
     * @return string|null
     */
    public function getName(): ?string{
        return $this->name;
    }

    /**
     * Set the category's name
     * @param string|null $name
     */
    public function setName(?string $name): void{
        $this->name = $name;
    }

}