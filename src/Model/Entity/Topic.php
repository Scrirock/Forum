<?php


namespace Scrirock\Forum\Model\Entity;


class Topic{

    private ?int $id;
    private ?int $fkCategory;
    private ?string $title;
    private ?string $content;

    /**
     * Topic constructor.
     * @param int|null $id
     * @param int|null $fkCategory
     * @param string|null $title
     * @param string|null $content
     */
    public function __construct(?int $id=null, ?int $fkCategory=null, ?string $title=null, ?string $content=null)
    {
        $this->id = $id;
        $this->fkCategory = $fkCategory;
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * Return the topic's id
     * @return int|null
     */
    public function getId(): ?int{
        return $this->id;
    }

    /**
     * Set the topic's id
     * @param int|null $id
     */
    public function setId(?int $id): void{
        $this->id = $id;
    }

    /**
     * Return the topic's category
     * @return int|null
     */
    public function getFkCategory(): ?int{
        return $this->fkCategory;
    }

    /**
     * Set the topic's category
     * @param int|null $fkCategory
     */
    public function setFkCategory(?int $fkCategory): void{
        $this->fkCategory = $fkCategory;
    }

    /**
     * Return the topic's title
     * @return string|null
     */
    public function getTitle(): ?string{
        return $this->title;
    }

    /**
     * Set the topic's title
     * @param string|null $title
     */
    public function setTitle(?string $title): void{
        $this->title = $title;
    }

    /**
     * Return the topic's content
     * @return string|null
     */
    public function getContent(): ?string{
        return $this->content;
    }

    /**
     * Set the topic's content
     * @param string|null $content
     */
    public function setContent(?string $content): void{
        $this->content = $content;
    }

}