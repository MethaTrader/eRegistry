<?php

namespace App\DTO;

class StatisticsData
{
    public function __construct(
        public readonly int $totalCount,
        public readonly int $currentMonthCount,
        public readonly int $lastMonthCount,
        public readonly int $percentChange
    ) {}

    public static function create(int $totalCount, int $currentMonthCount, int $lastMonthCount): self
    {
        $percentChange = $lastMonthCount > 0
            ? round((($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100)
            : 0;

        return new self($totalCount, $currentMonthCount, $lastMonthCount, $percentChange);
    }
}