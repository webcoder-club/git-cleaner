<?php
declare(strict_types=1);

namespace Git;

class Cleaner
{
    /** @var \Git\Branch\Provider */
    private $gitProvider;

    /** @var \Git\Branch\ActionsInterface */
    private $gitBranchActions;

    /**
     * Количество дней после которых необходимо удалить смерженную в мастер ветку
     * @var int
     */
    private $removeMergedDays = 7;

    /**
     * Количество дней после которых необходимо послать уведомление
     * @var int
     */
    private $notifyDays = 21;

    /**
     * Количество дней после которых необходимо удалить ветку
     * @var int
     */
    private $removeUnmergedDays = 30;

    /**
     * @param Branch\Provider $provider
     * @param Branch\ActionsInterface $actions
     */
    public function __construct(\Git\Branch\Provider $provider, \Git\Branch\ActionsInterface $actions)
    {
        $this->gitProvider = $provider;
        $this->gitBranchActions = $actions;
    }

    /**
     * @return int
     */
    public function getRemoveMergedDays(): int
    {
        return $this->removeMergedDays;
    }

    /**
     * @param int $removeMergedDays
     * @return Cleaner
     */
    public function setRemoveMergedDays(int $removeMergedDays): self
    {
        $this->removeMergedDays = $removeMergedDays;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotifyDays()
    {
        return $this->notifyDays;
    }

    /**
     * @param mixed $notifyDays
     * @return Cleaner
     */
    public function setNotifyDays($notifyDays): self
    {
        $this->notifyDays = $notifyDays;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRemoveUnmergedDays()
    {
        return $this->removeUnmergedDays;
    }

    /**
     * @param mixed $removeUnmergedDays
     * @return Cleaner
     */
    public function setRemoveUnmergedDays($removeUnmergedDays): self
    {
        $this->removeUnmergedDays = $removeUnmergedDays;
        return $this;
    }

    public function removeUnusedBranches()
    {
        $this->removeOld();

        $this->removeMerged();
    }

    /**
     * @param \Git\Ref[] $branches
     * @param $daysDiff
     * @param $action
     */
    private function execute(array $branches, int $daysDiff, callable $action)
    {
        /** @var \Git\Ref $branch */
        foreach ($branches as $branch) {
            if (\Helper::getDaysDiff($branch->getCommitterDate()) > $daysDiff) {
                $action($branch);
            }
        }
    }

    public function notify(callable $action)
    {
        $this->execute(
            $this->gitProvider->getOriginOnly(),
            $this->notifyDays,
            $action
        );
    }

    public function removeOld()
    {
        $this->execute(
            $this->gitProvider->getOriginOnly(\Git\Branch\Provider::$getNoMergedBranches),
            $this->removeUnmergedDays,
            function ($branch) {
                /** @var \Git\Ref $branch */
                $this->gitBranchActions->removeOne($branch->getRefName());
            }
        );
    }

    public function removeMerged()
    {
        $this->execute(
            $this->gitProvider->getOriginOnly(\Git\Branch\Provider::$getMergedBranches),
            $this->removeMergedDays,
            function ($branch) {
                /** @var \Git\Ref $branch */
                $this->gitBranchActions->removeOne($branch->getRefName());
            }
        );
    }
}