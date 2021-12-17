<?php


namespace Scrirock\Forum\Model\Entity;


class Comment{

    private ?int $id;
    private ?int $user;
    private ?int $topic;
    private ?string $content;
    private int $close;
    private int $signaled;

    /**
     * Comment constructor.
     * @param int|null $id
     * @param int|null $user
     * @param int|null $topic
     * @param string|null $content
     * @param int $close
     * @param int $signaled
     */
    public function __construct(?int $id=null, ?int $user=null, ?int $topic=null, ?string $content=null, int $close=0, int $signaled=0){
        $this->id = $id;
        $this->user = $user;
        $this->topic = $topic;
        $this->content = $content;
        $this->close = $close;
        $this->signaled = $signaled;
    }

    /**
     * Return the comment's id
     * @return int|null
     */
    public function getId(): ?int{
        return $this->id;
    }

    /**
     * Set the comment's id
     * @param int|null $id
     */
    public function setId(?int $id): void{
        $this->id = $id;
    }

    /**
     * Return the comment's
     * @return int|null
     */
    public function getUser(): ?int{
        return $this->user;
    }

    /**
     * Set the comment's user
     * @param int|null $user
     */
    public function setUser(?int $user): void{
        $this->user = $user;
    }

    /**
     * Return the comment's topic
     * @return int|null
     */
    public function getTopic(): ?int{
        return $this->topic;
    }

    /**
     * Set the comment's topic
     * @param int|null $topic
     */
    public function setTopic(?int $topic): void{
        $this->topic = $topic;
    }

    /**
     * Return the comment's content
     * @return string|null
     */
    public function getContent(): ?string{
        return $this->content;
    }

    /**
     * Set the comment's content
     * @param string|null $content
     */
    public function setContent(?string $content): void{
        $this->content = $content;
    }

    /**
     * Return the comment's status
     * @return int
     */
    public function getClose(): int{
        return $this->close;
    }

    /**
     * Set the comment's status
     * @param int $close
     */
    public function setClose(int $close): void{
        $this->close = $close;
    }

    /**
     * Return the comment's status
     * @return int
     */
    public function getSignaled(): int{
        return $this->signaled;
    }

    /**
     * Set the comment's status
     * @param int $signaled
     */
    public function setSignaled(int $signaled): void{
        $this->signaled = $signaled;
    }

}