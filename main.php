<?php

require 'vendor/autoload.php';

// С DI можно будет опустить аргументы
$gitCleaner = new \Git\Cleaner(
    new \Git\Branch\Provider(),
    new \Git\Branch\StdOutActions()
);

$gitCleaner->removeUnusedBranches();

$gitCleaner->setNotifyDays(0)->notify(
    function ($branch) {
        /** @var Git\Ref $branch */
        echo sprintf("%s %s\n", $branch->getAuthorEmail(), $branch->getRefName());
    }
);
