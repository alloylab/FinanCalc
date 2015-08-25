<?php

use FinanCalc\Calculators\DebtAmortizator;
use FinanCalc\Constants\Defaults;
use FinanCalc\FinanCalc;
use FinanCalc\Utils\MathFuncs;

/**
 * Class DebtAmortizatorTest
 */
class DebtAmortizatorTest extends PHPUnit_Framework_TestCase {

    /**
     * Test the "factory" version
     */
    public function testRepaymentsFactoryYearly() {
        // initialize a variable representing a DebtAmortizator
        // object obtained via a FACTORY method
        $debtAmortizatorFactory = FinanCalc
            ::getInstance()
            ->getFactory('DebtAmortizatorFactory')
            ->newYearlyDebtAmortization(
                40000,
                6,
                0.12);

        $this->processResult($debtAmortizatorFactory);
        $this->processArray($debtAmortizatorFactory->getResultAsArray());
    }

    /**
     * Test the "direct" version
     */
    public function testRepaymentsDirectYearly() {
        // initialize a variable representing a DebtAmortizator
        // object obtained via DIRECT instantiation
        $debtAmortizatorDirect = new DebtAmortizator(
            40000,
            6,
            Defaults::LENGTH_YEAR_360_30,
            0.12);

        $this->processResult($debtAmortizatorDirect);
        $this->processArray($debtAmortizatorDirect->getResultAsArray());
    }

    /**
     * Test the monthly factory version
     */
    public function testRepaymentsFactoryMonthly() {
        // initialize a variable representing a DebtAmortizator
        // object obtained via a FACTORY method
        $debtAmortizatorFactory = FinanCalc
            ::getInstance()
            ->getFactory('DebtAmortizatorFactory')
            ->newMonthlyDebtAmortization(
                40000,
                6,
                0.12);

        $this->processResult($debtAmortizatorFactory);
        $this->processArray($debtAmortizatorFactory->getResultAsArray());
    }

    /**
     * Test the daily factory version
     */
    public function testRepaymentsFactoryDaily() {
        // initialize a variable representing a DebtAmortizator
        // object obtained via a FACTORY method
        $debtAmortizatorFactory = FinanCalc
            ::getInstance()
            ->getFactory('DebtAmortizatorFactory')
            ->newDailyDebtAmortization(
                40000,
                6,
                0.12);

        $this->processResult($debtAmortizatorFactory);
        $this->processArray($debtAmortizatorFactory->getResultAsArray());
    }

    /**
     * Test the yearly version, manufactured by a custom period length factory
     */
    public function testRepaymentsFactoryCustom() {
        // initialize a variable representing a DebtAmortizator
        // object obtained via a FACTORY method
        $debtAmortizatorFactory = FinanCalc
            ::getInstance()
            ->getFactory('DebtAmortizatorFactory')
            ->newDebtAmortizationCustomPeriodLength(
                40000,
                6,
                0.12,
                Defaults::LENGTH_YEAR_360_30);

        $this->processResult($debtAmortizatorFactory);
        $this->processArray($debtAmortizatorFactory->getResultAsArray());
    }


    /**
     * @param DebtAmortizator $result
     */
    private function processResult(DebtAmortizator $result) {
        $this->assertEquals("40000", $result->getDebtPrincipal());
        $this->assertEquals("6", $result->getDebtNoOfCompoundingPeriods());

        $this->assertEquals(
            MathFuncs::div(
                $result->getDebtPeriodLengthInDays(),
                Defaults::LENGTH_YEAR_360_30
            ),
            $result->getDebtPeriodLengthInYears());
        $this->assertEquals(
            MathFuncs::div(
                $result->getDebtPeriodLengthInDays(),
                Defaults::LENGTH_MONTH_360_30
            ),
            $result->getDebtPeriodLengthInMonths());

        $this->assertEquals(
            MathFuncs::div(
                $result->getDebtDurationInDays(),
                Defaults::LENGTH_YEAR_360_30
            ),
            $result->getDebtDurationInYears());
        $this->assertEquals(
            MathFuncs::div(
                $result->getDebtDurationInDays(),
                Defaults::LENGTH_MONTH_360_30
            ),
            $result->getDebtDurationInMonths());

        $this->assertEquals("0.12", $result->getDebtInterest());

        $repayments = $result->getDebtRepayments();

        $INDIVIDUAL_REPAYMENT = "9729.03";
        $this->assertEquals("4929.03", round($repayments[1]->getPrincipalAmount(), 2));
        $this->assertEquals("4800.00", round($repayments[1]->getInterestAmount(), 2));
        $this->assertEquals($INDIVIDUAL_REPAYMENT, round($repayments[1]->getTotalAmount(), 2));

        $this->assertEquals("5520.51", round($repayments[2]->getPrincipalAmount(), 2));
        $this->assertEquals("4208.52", round($repayments[2]->getInterestAmount(), 2));
        $this->assertEquals($INDIVIDUAL_REPAYMENT, round($repayments[2]->getTotalAmount(), 2));

        $this->assertEquals("6182.97", round($repayments[3]->getPrincipalAmount(), 2));
        $this->assertEquals("3546.06", round($repayments[3]->getInterestAmount(), 2));
        $this->assertEquals($INDIVIDUAL_REPAYMENT, round($repayments[3]->getTotalAmount(), 2));

        $this->assertEquals("6924.93", round($repayments[4]->getPrincipalAmount(), 2));
        $this->assertEquals("2804.10", round($repayments[4]->getInterestAmount(), 2));
        $this->assertEquals($INDIVIDUAL_REPAYMENT, round($repayments[4]->getTotalAmount(), 2));

        $this->assertEquals("7755.92", round($repayments[5]->getPrincipalAmount(), 2));
        $this->assertEquals("1973.11", round($repayments[5]->getInterestAmount(), 2));
        $this->assertEquals($INDIVIDUAL_REPAYMENT, round($repayments[5]->getTotalAmount(), 2));

        $this->assertEquals("8686.63", round($repayments[6]->getPrincipalAmount(), 2));
        $this->assertEquals("1042.4", round($repayments[6]->getInterestAmount(), 2));
        $this->assertEquals($INDIVIDUAL_REPAYMENT, round($repayments[6]->getTotalAmount(), 2));
    }


    /**
     * @param array $resultArray
     */
    private function processArray(array $resultArray) {
        $this->assertEquals("40000", $resultArray["debtPrincipal"]);
        $this->assertEquals("6", $resultArray["debtNoOfCompoundingPeriods"]);

        $this->assertEquals(
            MathFuncs::div(
                $resultArray["debtPeriodLength"]["days"],
                Defaults::LENGTH_YEAR_360_30
            ),
            $resultArray["debtPeriodLength"]["years"]);
        $this->assertEquals(
            MathFuncs::div(
                $resultArray["debtPeriodLength"]["days"],
                Defaults::LENGTH_MONTH_360_30
            ),
            $resultArray["debtPeriodLength"]["months"]);

        $this->assertEquals(
            MathFuncs::div(
                $resultArray["debtDuration"]["days"],
                Defaults::LENGTH_YEAR_360_30
            ),
            $resultArray["debtDuration"]["years"]);
        $this->assertEquals(
            MathFuncs::div(
                $resultArray["debtDuration"]["days"],
                Defaults::LENGTH_MONTH_360_30
            ),
            $resultArray["debtDuration"]["months"]);

        $this->assertEquals("0.12", $resultArray["debtInterest"]);

        $repayments = $resultArray["debtRepayments"];

        $INDIVIDUAL_REPAYMENT = "9729.03";
        $this->assertEquals("4929.03", round($repayments[1]["principalAmount"], 2));
        $this->assertEquals("4800.00", round($repayments[1]["interestAmount"], 2));
        $this->assertEquals($INDIVIDUAL_REPAYMENT, round($repayments[1]["totalAmount"], 2));

        $this->assertEquals("5520.51", round($repayments[2]["principalAmount"], 2));
        $this->assertEquals("4208.52", round($repayments[2]["interestAmount"], 2));
        $this->assertEquals($INDIVIDUAL_REPAYMENT, round($repayments[2]["totalAmount"], 2));

        $this->assertEquals("6182.97", round($repayments[3]["principalAmount"], 2));
        $this->assertEquals("3546.06", round($repayments[3]["interestAmount"], 2));
        $this->assertEquals($INDIVIDUAL_REPAYMENT, round($repayments[3]["totalAmount"], 2));

        $this->assertEquals("6924.93", round($repayments[4]["principalAmount"], 2));
        $this->assertEquals("2804.10", round($repayments[4]["interestAmount"], 2));
        $this->assertEquals($INDIVIDUAL_REPAYMENT, round($repayments[4]["totalAmount"], 2));

        $this->assertEquals("7755.92", round($repayments[5]["principalAmount"], 2));
        $this->assertEquals("1973.11", round($repayments[5]["interestAmount"], 2));
        $this->assertEquals($INDIVIDUAL_REPAYMENT, round($repayments[5]["totalAmount"], 2));

        $this->assertEquals("8686.63", round($repayments[6]["principalAmount"], 2));
        $this->assertEquals("1042.4", round($repayments[6]["interestAmount"], 2));
        $this->assertEquals($INDIVIDUAL_REPAYMENT, round($repayments[6]["totalAmount"], 2));
    }

    /**
     * Test presence in the main factories array
     */
    public function testPresenceInMainFactoriesArray() {
        $this->assertTrue(
            isObjectTypeInArray('FinanCalc\\Calculators\\Factories\\BondYTMCalculatorFactory', \FinanCalc\FinanCalc::getInstance()->getFactories())
        );
    }
}
