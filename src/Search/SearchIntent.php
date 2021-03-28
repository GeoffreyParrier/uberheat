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
     * @throws Exception Stringify error in query
     */
    public function setSearch(object $query): void
    {
        try {
            $this->isValidQueryFormat($query);
        } catch (Exception $e) {
            throw new Exception('Bad format for search format, ' . strtolower($e->getMessage()));
        }

        $this->searchType = $query->type;
        $this->conditions = $query->conditions;
    }

    /**
     * @param object $query JSON search query decoded in array format
     * @return bool true if query format is valid
     * @throws Exception the error in the query
     */
    private function isValidQueryFormat(object $query): bool
    {
        $requiredQueryProperties = ['type', 'conditions'];

        // Check if required search properties exist in $query
        foreach ($requiredQueryProperties as $requiredQueryProperty) {
            if (!property_exists($query, $requiredQueryProperty)) {
                throw new Exception(sprintf('Missing property "%s"', $requiredQueryProperty));
            }
        }

        // Check if $query has only accepted properties
        $queryPropertiesArray = get_object_vars($query);
        foreach ($queryPropertiesArray as $queryProperty => $queryPropertyValue) {
            if (!in_array($queryProperty, $requiredQueryProperties, true)) {
                throw new Exception(sprintf('Unknown property "%s", only [%s] are accepted', $queryProperty, implode(', ', $requiredQueryProperties)));
            }
        }


        // Check all conditions properties
        $conditions = $query->conditions;
        $requiredConditionProperties = ['property', 'rule', 'value'];

        foreach ($conditions as $condition) {

            // Check if required condition properties exist in all conditions
            foreach ($requiredConditionProperties as $validConditionProperty) {
                if (!property_exists($condition, $validConditionProperty)) {
                    throw new Exception(sprintf('Missing property "%s" in conditions', $validConditionProperty));
                }
            }

            // Check if all conditions has only accepted properties
            $conditionPropertiesArray = get_object_vars($condition);

            foreach ($conditionPropertiesArray as $conditionPropertyName => $conditionValue) {
                if (!in_array($conditionPropertyName, $requiredConditionProperties, true)) {
                    throw new Exception(sprintf('Unknown property "%s" in conditions, only [%s] are accepted', $conditionPropertyName, implode(', ', $requiredConditionProperties)));
                }
            }
        }

        return true;
    }
}