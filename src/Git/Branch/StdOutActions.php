<?php
declare(strict_types=1);

namespace Git\Branch;

class StdOutActions extends AbstractActions
{
    public function __construct()
    {
        $this->cmd = 'print';
    }
}