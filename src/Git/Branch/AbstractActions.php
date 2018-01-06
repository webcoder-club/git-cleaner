<?php
declare(strict_types=1);

namespace Git\Branch;

class AbstractActions implements ActionsInterface
{
    protected $cmd;

    /**
     * @param array $names
     * @throws \Exception
     */
    public function removeBulk(array $names)
    {
        foreach ($names as $name) {
            $this->removeOne($name);
        }
    }

    /**
     * @param string $name
     * @throws \Exception
     */
    public function removeOne(string $name)
    {
        if (!\Helper::isStringStartWith($name, self::ORIGIN)) {
            throw new \Exception('Delete only origin branches');
        }

        $name = str_replace(self::ORIGIN, '', $name);

        // todo: Грязнущий хак, потому что $this->cmd() начинает искать метод
        $command = $this->cmd;
        $command(self::REMOVE_BRANCH . $name);
    }
}