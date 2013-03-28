<?php

require_once '../StringCalculator.php';

class StringCalculatorTest extends PHPUnit_Framework_TestCase
{
    public function test_add_takeZeroAsString_returnZeroAsNumber()
    {
        $this->expectAddResult("", 0);
    }

    public function test_add_oneNumber_getNumberBack()
    {
        $this->expectAddResult("1", 1);
    }

    public function test_add_justRealNumber_returnsThatNumber()
    {
        $this->expectAddResult(5, 5);
    }

    public function test_add_twoNumbersInString_sumNumbersAndReturnResult()
    {
        $this->expectAddResult("1,2", 3);
    }

    public function test_add_handleUnknownAmountOfNumbers_sumAllTogether()
    {
        $this->expectAddResult("1,2,3,4,5,6,7,8,9", 45);
    }

    public function test_add_handleAlsoNewLinesInsteadOfComma_sumAllTogether()
    {
        $this->expectAddResult("1\n2,3", 6);
    }

    public function test_add_takesDelimiterAtStart_useCustomDelimiterAsFilter()
    {
        $this->expectAddResult("//;\n1;2", 3);
    }

    public function test_add_numbersBiggerThen1000_shouldBeIgnored()
    {
        $this->expectAddResult("2,2000", 2);
    }

    /**
     * @expectedException Exception
     */
    public function test_add_negativeNumber_throwNegativesNotAllowedException()
    {
        $this->expectAddResult("-1,-5,5", -1);
    }

    /**
     * @return StringCalculator
     */
    private function makeCalculator()
    {
        return new StringCalculator();
    }

    /**
     * @param $numbers
     * @param $expectedResult
     */
    private function expectAddResult($numbers, $expectedResult)
    {
        $calculator = $this->makeCalculator();

        $result = $calculator->add($numbers);

        $this->assertEquals($expectedResult, $result);
    }

}