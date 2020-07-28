<?php

namespace App\Repositories;

use App\Helper;
use App\Models\Earning;
use App\Models\Spending;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class TransactionRepository
{
    public function getWeeklyBalance(string $year): array
    {
        $weeks = [];
        $balance = 0;

        $weekMode = 3;

        if (date('w', strtotime($year . '-01-01')) == 1) {
            $weekMode = 7;
        }

        for ($i = 1; $i <= 53; $i++) { // This used to be 52, IDK what happens after we moved it to 53
            $balance += Earning::ofSpace(session('space_id'))
                ->whereRaw('YEAR(happened_on) = ? AND WEEK(happened_on, ?) = ?', [$year, $weekMode, $i])
                ->sum('amount');

            $balance -= Spending::ofSpace(session('space_id'))
                ->whereRaw('YEAR(happened_on) = ? AND WEEK(happened_on, ?) = ?', [$year, $weekMode, $i])
                ->sum('amount');

            $weeks[$i] = Helper::formatNumber($balance / 100);
        }

        return $weeks;
    }

    public function getTransactionsByYearMonth(array $filterBy = [])
    {
        $yearMonths = [];

        // Populate yearMonths with earnings
        foreach (Earning::ofSpace(session('space_id'))->get() as $earning) {
            $shouldAdd = false;

            if (!$filterBy) {
                $shouldAdd = true;
            }

            if ($shouldAdd) {
                $i = Carbon::parse($earning->happened_on)->format('Y-m');

                if (!isset($yearMonths[$i])) {
                    $yearMonths[$i] = [];
                }

                $yearMonths[$i][] = $earning;
            }
        }

        // Populate yearMonths with spendings
        foreach (Spending::ofSpace(session('space_id'))->get() as $spending) {
            $shouldAdd = true;

            // Filter
            if (count($filterBy)) { // Check if any filters were provided
                if ($filterBy[0] == 'tag') {
                    if (!$spending->tag || $spending->tag->id != $filterBy[1]) {
                        $shouldAdd = false;
                    }
                }
            }

            if ($shouldAdd) {
                $i = Carbon::parse($spending->happened_on)->format('Y-m');

                if (!isset($yearMonths[$i])) {
                    $yearMonths[$i] = [];
                }

                $yearMonths[$i][] = $spending;
            }
        }

        // Sort transactions
        foreach ($yearMonths as &$yearMonth) {
            usort($yearMonth, function ($a, $b) {
                return $a->happened_on < $b->happened_on;
            });
        }

        // Sort yearMonths
        krsort($yearMonths);

        return $yearMonths;
    }

    public function getBySpaceId(int $spaceId): Collection
    {
        $earnings = Earning::where('space_id', $spaceId)
            ->get();

        $spendings = Spending::where('space_id', $spaceId)
            ->get();

        return $earnings->merge($spendings);
    }
}
