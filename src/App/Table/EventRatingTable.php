<?php declare(strict_types=1);

namespace App\Table;

use Administration\Table\AbstractTable;
use Envms\FluentPDO\Query;

class EventRatingTable extends AbstractTable
{
    public function __construct(Query $query)
    {
        parent::__construct($query, 'EventRating');
    }
}