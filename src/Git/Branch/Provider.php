<?php
declare(strict_types=1);

namespace Git\Branch;

class Provider
{
    /**
     * @var string
     */
    private $originMasterBranch = "origin/master";

    public const FORMAT_GET = " --format='%(refname:short),%(objectname:short),%(authoremail),%(committerdate:unix)'";

    /**
     * Получить список всех веток
     * @see https://git-scm.com/docs/git-for-each-ref
     */
    public const GET_BRANCHES = "git for-each-ref --sort=committerdate" . self::FORMAT_GET;

    /**
     * Получить список не вмерженных в мастер веток
     * @var string
     */
    public static $getNoMergedBranches;

    /**
     * Получить список всех вмерженных в мастер веток
     * @var string
     */
    public static $getMergedBranches;

    /**
     * Список доступных команд
     * @var array
     */
    public $gitCommands;

    public function __construct()
    {
        self::$getNoMergedBranches = self::GET_BRANCHES . " --no-merged='{$this->originMasterBranch}'";
        self::$getMergedBranches = self::GET_BRANCHES . " --merged='{$this->originMasterBranch}'";

        $this->gitCommands = [
            self::GET_BRANCHES,
            self::$getNoMergedBranches,
            self::$getMergedBranches,
        ];
    }

    /**
     * @param string $originMasterBranch
     * @return Provider
     */
    public function setOriginMasterBranch(string $originMasterBranch): self
    {
        $this->originMasterBranch = $originMasterBranch;
        return $this;
    }

    /**
     * @param string $command
     * @return \Git\Ref[]
     * @throws \Exception
     */
    public function getBranchList($command = self::GET_BRANCHES)
    {
        if (!in_array($command, $this->gitCommands)) {
            throw new \Exception("Неизвестная команда!");
        }

        // Получаем список всех веток
        $branches = shell_exec($command);

        // Почему не использовать explode() вместо str_getcsv() для парсинга строк?
        // Because explode() would not treat possible enclosured parts of string or escaped characters correctly.
        $branchesInfo = str_getcsv($branches, "\n");

        $results = [];
        foreach ($branchesInfo as $branch) {
            $raw = explode(',', $branch);

            // Никаких операций с origin/master!
            if ($raw[0] != $this->originMasterBranch) {
                $results[] = new \Git\Ref($raw);
            }
        }

        return $results;
    }

    /**
     * @param string $command
     * @return \Git\Ref[]
     * @throws \Exception
     */
    public function getOriginOnly($command = self::GET_BRANCHES)
    {
        return $this->filter($command, 'origin/');
    }

    /**
     * @param string $command
     * @return \Git\Ref[]
     * @throws \Exception
     */
    public function getHotFixOnly($command = self::GET_BRANCHES)
    {
        return $this->filter($command, 'origin/hotfix');
    }

    /**
     * @param string $command
     * @param string $name
     * @return \Git\Ref[]
     * @throws \Exception
     */
    private function filter(string $command = self::GET_BRANCHES, string $name): array
    {
        $branches = $this->getBranchList($command);
        $results = [];

        foreach ($branches as $branch) {
            if (\Helper::isStringStartWith($name, $branch->getRefName())) {
                $results[] = $branch;
            }
        }

        return $results;
    }
}