<?php


namespace App\Search;


use Exception;

class SearchIntent
{
    private string $searchType;

    private array $conditions;

    /**
     * @return string
     */
    public function getSearchType(): string
    {
        return $this->searchType;
    }

    /**
     * @return array
     */
    public function getConditions(): array
    {
        return $this->conditions;
    }

    /**
     * @param object $query JSON search query decoded in array format
     * @throws Exception
     */
    public function setSearch(object $query): void
    {
//        if ($this->isValidQueryFormat($query)) {
//            throw new Exception('Bad format for search format');
//        }

        $this->searchType = $query->type;
        $this->conditions = $query->conditions;
    }

    /**
     * @param array $query JSON search query decoded in array format
     * @return bool
     */
    private function isValidQueryFormat(array $query): bool
    {
        $validSearchProperties = ['type', 'conditions'];

        // Check if query has only accepted and required search properties
        foreach ($query as $queryProperty) {
            if (!in_array($queryProperty, $validSearchProperties, true)) {
                return false;
            }

            $isCurrentPropertyValid = false;
            foreach ($validSearchProperties as $validSearchProperty) {
                if ($queryProperty === $validSearchProperty) {
                    $isCurrentPropertyValid = true;
                }
            }

            if (!$isCurrentPropertyValid) {
                return false;
            }
        }

        foreach ($query['conditions'] as $condition) {
            foreach ($condition as $index => $conditionSettings) {
                $validConditionIndexes = ['property', 'condition', 'value'];

                if (!in_array($index, $validConditionIndexes, true)) {
                    return false;
                }

                $isCurrentSettingValid = false;
                foreach ($validConditionIndexes as $validConditionIndex) {
                    if ($conditionSettings === $validConditionIndex) {
                        $isCurrentSettingValid = true;
                    }
                }

                if (!$isCurrentSettingValid) {
                    return false;
                }
            }
        }

        return true;
    }
}