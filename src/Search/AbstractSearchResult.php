<?php

namespace App\Search;

use Symfony\Component\Validator\Constraints\Json;

abstract class AbstractSearchResult
{
    abstract public function getSearchResult(Object $condition): Json;

    abstract public function saveSearchResult(Object $condition): Json;
}
