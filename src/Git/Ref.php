<?php
declare(strict_types=1);

namespace Git;

class Ref
{
    /** @var string */
    private $refName;

    /** @var string */
    private $objectName;

    /** @var string */
    private $authorEmail;

    /** @var \DateTime */
    private $committerDate;

    public function __construct(array $ref)
    {
        if (count($ref) != 4) {
            throw new \Exception('Error in ref ' . implode(',', $ref));
        }

        $this->refName = $ref[0];
        $this->objectName = $ref[1];
        $this->authorEmail = $this->parseEmail($ref[2]);
        $this->committerDate = (new \DateTime())->setTimestamp((int)$ref[3]);
    }

    public function __toString(): string
    {
        return sprintf("%s %s %s %s\n",
            $this->refName,
            $this->objectName,
            $this->authorEmail,
            $this->committerDate->format('d-m-Y')
        );
    }

    /**
     * @return string
     */
    public function getRefName(): string
    {
        return $this->refName;
    }

    /**
     * @return \DateTime
     */
    public function getCommitterDate(): \DateTime
    {
        return $this->committerDate;
    }

    /**
     * Необходимо из <isomov@avito.ru> сделать isomov@avito.ru
     * @param string $ref
     * @return string
     */
    private function parseEmail(string $ref): string
    {
        return mb_substr($ref, 1, -1);
    }

    /**
     * @return string
     */
    public function getAuthorEmail(): string
    {
        return $this->authorEmail;
    }
}