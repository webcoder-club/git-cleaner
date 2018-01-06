<?php
declare(strict_types=1);

namespace Git\Branch;

class ExecActions extends AbstractActions
{
    public function __construct()
    {
        $this->cmd = 'shell_exec';
    }
}