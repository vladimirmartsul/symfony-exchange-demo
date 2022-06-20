<?php
declare(strict_types=1);

namespace App\Services;

use App\Entity\Pair;
use App\Entity\Rate;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Triangulation simple official rates to all pairs combinations
 */
class RatesTriangulator
{
    public function __construct(private readonly ManagerRegistry $doctrine)
    {
    }


    public function __invoke(): void
    {
        $ratesTable = $this->doctrine->getManager()->getClassMetadata(Rate::class)->getTableName();
        $pairsTable = $this->doctrine->getManager()->getClassMetadata(Pair::class)->getTableName();

        $sql = "INSERT OR IGNORE INTO $pairsTable (date, base, currency, rate)
SELECT date, base, currency, rate FROM $ratesTable
UNION ALL
SELECT DISTINCT pair.date, pair.base, pair.currency, pair.rate
FROM (SELECT f.date, f.base, t.base currency, round(CAST (f.rate AS REAL) / CAST (t.rate AS REAL), 8) rate
      FROM $ratesTable f,
           $ratesTable t
      WHERE f.currency = t.currency) pair
         LEFT OUTER JOIN $ratesTable r
                         ON pair.base = r.base
                             AND pair.currency = r.currency
WHERE r.base IS NULL";

        $this->doctrine->getConnection()->executeStatement($sql);
    }
}
