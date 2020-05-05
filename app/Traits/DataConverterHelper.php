<?php

namespace App\Traits;

use DateTime;

trait DataConverterHelper
{
    /**
     * Convert comma separated fields
     *
     * @param String $fields   e.g. "id,name,study abroad"
     *
     * @return array e.g ['id', 'name', 'study abroad']
     */
    public function convertCommaSeparated($fields = null)
    {
        if (!$this->checkString($fields)) {
            return [];
        }

        $separatedValues = array();

        foreach (array_unique(explode(',', $fields)) as $field) {
            array_push($separatedValues, $field);
        }

        return $separatedValues;
    }

    /**
     * Convert sort value format
     *
     * @param String $sorts         | e.g. "+name,-id"
     * @param Array $fields         | Given fields values from the request e.g. ['id', 'name']
     * @param Array $sortableFields | Available sortable fields based on the endpoint e.g ['id', 'name', 'abbrv']
     *
     * @return array e.g. ['+name', '+id']
     */
    public function convertSort($sorts = null, array $fields = [], array $sortableFields = [])
    {
        if (!$this->checkString($sorts)) {
            return [];
        }

        $separatedValues = array();
        $availableSortableFields = $this->checkValidSortableFields($fields, $sortableFields);

        foreach (array_unique(explode(',', $sorts)) as $sort) {
            $sort = strpos($sort, "+") !== false ? $sort : urlencode($sort);
            if (!in_array(substr($sort, 1), $availableSortableFields)) {
                throw new \InvalidArgumentException;
            }

            array_push($separatedValues, $sort);
        }

        return $separatedValues;
    }

    /**
     * Convert sort value format
     *
     * @param String $sorts         | e.g. "+name,-id"
     * @param Array $fields         | Given fields values from the request (e.g. ['id', 'name'])
     * @param Array $sortableFields | Available sortable fields based on the endpoint (e.g ['id', 'name', 'abbrv'])
     *
     * @return array e.g. [['column' => 'name', 'direction' => 'asc'], ['column' => 'id', 'direction' => 'desc']]
     */
    public function convertSortFormat($sorts = null, array $fields = [], array $sortableFields = [])
    {
        if (!$this->checkString($sorts)) {
            return [];
        }

        $separatedValues = array();
        $sorts = $this->convertSort($sorts, $fields, $sortableFields);
        
        // Check if given sort value is declared in the correct fields
        foreach ($sorts as $sort) {
            array_push(
                $separatedValues,
                [
                    'column' => substr($sort, 1),
                    'direction' => ('+' == substr($sort, 0, 1)) ? 'asc' : 'desc'
                ]
            );
        }

        return $separatedValues;
    }

    /**
     * Check if fields in the url parameters matched the available sortable fields of the given model
     *
     * @param Array $fields            | Given fields values from the request
     * @param Array $sortableFields    | Available sortable fields based on the endpoint
     *
     * @return array
     */
    private function checkValidSortableFields(array $fields = [], array $sortableFields = [])
    {
        if (!count($sortableFields) && !count($fields)) {
            return [];
        }

        if (count($fields) && !count($sortableFields)) {
            return $fields;
        }

        if (count($sortableFields) && !count($fields)) {
            return $sortableFields;
        }

        // Returns array of available and correct sort fields
        return array_intersect($sortableFields, $fields);
    }

    /**
     * Check date value
     *
     * @param String $dates   e.g. "+2017-01-01,2016-01-01"
     *
     * @return array e.g. ['+2017-01-01', '2016-01-01']
     */
    public function convertDate($dates = null)
    {
        if (!$this->checkString($dates)) {
            return [];
        }

        $separatedValues = array();
        
        foreach (array_unique(explode(',', $dates)) as $date) {
            $date = strpos($date, "+") !== false ? $date : urlencode($date);
            
            array_push($separatedValues, $date);
        }

        return $separatedValues;
    }

    /*
     * Check date with possible range values
     *
     * @param String $dates   e.g. "2016-01-01,2017-01-01"
     *
     * @return array e.g ['2016-01-01', '2017-01-01']
     */
    public function convertDateRange($dates = null)
    {
        $dates = $this->convertDate($dates);

        // Check if given dates are greater than 2, then it is not acceptable range value
        if (count($dates) > 2) {
            throw new \InvalidArgumentException;
        }

        // Check if value is range and should not have + or - before the given dates
        if (count($dates) == 2) {
            foreach ($dates as $date) {
                $pattern = '/^((\d{4})\-(0?[1-9]|1[012])\-(0?[1-9]|[12][0-9]|3[01]))$/';
                    
                if (!preg_match($pattern, $date)) {
                    throw new \InvalidArgumentException;
                }
            }
        }

        return $dates;
    }

    /**
     * Check date with possible range values and format the result
     *
     * @param array $dates   e.g. ['2016-01-01', '+2017-01-01']
     *
     * @return array e.g [['date' => '2016-01-01', 'comparison' => '='], ['date' => '2017-01-01', 'comparison' => '>', ]]
     */
    public function convertDateFormat(array $dates = [])
    {
        $comparison = [
            ''  => '=',
            '+' => '>',
            '-' => '<'
        ];

        $separatedValues = [];
        foreach ($dates as $date) {
            $prefix = (substr($date, 0, 1) == '+' || substr($date, 0, 1) == '-') ? substr($date, 0, 1) : '';
            $the_date = substr($date, -10, 10);
            array_push($separatedValues, ['date' => $the_date, 'comparison' => $comparison[$prefix]]);
        }

        return $separatedValues;
    }

    private function checkString($string = null)
    {
        if ((empty($string) || !is_string($string)) && ($string !== '0')) {
            return false;
        }

        return true;
    }

    /**
     * Convert numeric range values
     *
     * @param String $numericRange   e.g. "gte:-5,lt:100.0" or "10,-5.0"
     *
     * @return array e.g [['value': -5, 'range':'>='], ['value': 100.00, 'range':'<']] or [['value': 10, 'range':'='], ['value': -5.0, 'range':'=']]
     */
    public function convertNumericRange($numericRange = null)
    {
        if (is_null($numericRange) || !is_string($numericRange)) {
            return [];
        }

        $arrayValues = explode(',', $numericRange);
        $pattern = '/gte:|gt:|lte:|lt:/';
        if (preg_match($pattern, $numericRange)) {
            $pattern = '/^(gte|gt|lte|lt)+:(-?(?:\d+|\d*\.\d+))$/';
            $separatedValues = [];
            foreach ($arrayValues as $key => $value) {
                preg_match($pattern, $value, $pmValue);
                switch ($pmValue[1]) {
                    case 'gt':
                        $separatedValues[] = ['value'=>(double) $pmValue[2], 'range'=>'>'];
                        break;
                    
                    case 'gte':
                        $separatedValues[] = ['value'=>(double) $pmValue[2], 'range'=>'>='];
                        break;

                    case 'lt':
                        $separatedValues[] = ['value'=>(double) $pmValue[2], 'range'=>'<'];
                        break;

                    default:
                         $separatedValues[] = ['value'=>(double) $pmValue[2], 'range'=>'<='];
                        break;
                }
            }
        } else {
            $separatedValues = [];
            foreach ($arrayValues as $key => $value) {
                $separatedValues[] = ['value'=> (double) $value, 'range'=>'='];
            }
        }

        return $separatedValues;
    }
}
