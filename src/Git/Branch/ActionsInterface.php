<?php
declare(strict_types=1);

namespace Git\Branch;

interface ActionsInterface
{
    /**
     * Префикс remote ветки
     */
    public const ORIGIN = 'origin/';

    /**
     * Удалить remote ветку
     */
    public const REMOVE_BRANCH = 'git push origin :';

    public function removeOne(string $name);

    public function removeBulk(array $names);
}