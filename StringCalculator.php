<?php

/**
 * Class StringCalculator
 */
class StringCalculator
{
    /**
     * @var string
     */
    private $delimiter = ';';

    /**
     * @var string
     */
    private $customDelimiter = "//;\n";

    /**
     * @var array
     */
    private $negativeNumbers = array();

    /**
     * @param $numbers
     *
     * @return int
     */
    public function add($numbers)
    {
        if (is_string($numbers)) {
            return $this->addString($numbers);
        }

        return $numbers;
    }

    /**
     * @param $stringNumbers
     *
     * @return int
     */
    private function addString($stringNumbers)
    {
        if ($this->hasCustomDelimiter($stringNumbers)) {
            $delimitedStringNumbers = str_replace($this->customDelimiter, '', $stringNumbers);

            $numbers = $this->filterNumbers($delimitedStringNumbers, $this->delimiter);
        } else {
            $numbers = $this->filterNumbers($stringNumbers);
        }
        $result = $this->calculateNumbers($numbers);

        return $result;
    }

    /**
     * @param $stringNumbers
     *
     * @return bool
     */
    private function hasCustomDelimiter($stringNumbers)
    {
        return !strncmp($stringNumbers, $this->customDelimiter, strlen($this->customDelimiter));
    }

    /**
     * @param $numbers
     *
     * @return int
     * @throws Exception
     */
    private function calculateNumbers($numbers)
    {
        $result = 0;

        foreach ($numbers as $number) {
            if ($this->isValidNumber($number)) {
                $result += $number;
            }
        }

        if ($this->hasNegativeNumbers()) {
            $errorMessage = sprintf('negatives not allowed (%s)', implode(', ', $this->negativeNumbers));
            throw new Exception($errorMessage);
        }

        return $result;
    }

    /**
     * @param $number
     *
     * @return boo
     */
    private function isValidNumber($number)
    {
        if ($number < 0) {
            array_push($this->negativeNumbers, $number);
        }

        if ($number > 1000) {
            return false;
        }

        return true;
    }

    /**
     * @param string $stringNumbers
     * @param string $delimiter
     *
     * @return array
     */
    private function filterNumbers($stringNumbers, $delimiter = ',')
    {
        $numbers = array();

        $explodedNumbersWithComma = explode($delimiter, $stringNumbers);

        foreach ($explodedNumbersWithComma as $number) {
            $explodedNumberWithNewline = explode("\n", $number);

            if (is_array($explodedNumberWithNewline)) {
                foreach ($explodedNumberWithNewline as $newlineNumber) {
                    array_push($numbers, $newlineNumber);
                }
            } else {
                array_push($numbers, $number);
            }
        }

        return $numbers;
    }

    /**
     * @return bool
     */
    private function hasNegativeNumbers()
    {
        return !empty($this->negativeNumbers);
    }
}