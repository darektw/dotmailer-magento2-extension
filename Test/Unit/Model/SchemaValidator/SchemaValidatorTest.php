<?php

namespace Dotdigitalgroup\Email\Test\Unit\Model\SchemaValidator;

use Dotdigitalgroup\Email\Model\Validator\Schema\Rule\DateFormatRule;
use Dotdigitalgroup\Email\Model\Validator\Schema\Rule\DateFormatRuleFactory;
use Dotdigitalgroup\Email\Model\Validator\Schema\Rule\IsFloatRule;
use Dotdigitalgroup\Email\Model\Validator\Schema\Rule\IsFloatRuleFactory;
use Dotdigitalgroup\Email\Model\Validator\Schema\Rule\IsIntRule;
use Dotdigitalgroup\Email\Model\Validator\Schema\Rule\IsIntRuleFactory;
use Dotdigitalgroup\Email\Model\Validator\Schema\Rule\IsStringRule;
use Dotdigitalgroup\Email\Model\Validator\Schema\Rule\IsStringRuleFactory;
use Dotdigitalgroup\Email\Model\Validator\Schema\Rule\RequiredRule;
use Dotdigitalgroup\Email\Model\Validator\Schema\Rule\RequiredRuleFactory;
use Dotdigitalgroup\Email\Model\Validator\Schema\Rule\UrlRule;
use Dotdigitalgroup\Email\Model\Validator\Schema\Rule\UrlRuleFactory;
use Dotdigitalgroup\Email\Model\Validator\Schema\SchemaValidator;
use Dotdigitalgroup\Email\Model\Validator\Schema\SchemaValidatorRule;
use Dotdigitalgroup\Email\Model\Validator\Schema\SchemaValidatorRuleFactory;
use Dotdigitalgroup\Email\Model\Validator\Schema\SchemaValidatorRuleSet;
use Dotdigitalgroup\Email\Model\Validator\Schema\SchemaValidatorRuleSetFactory;
use PHPUnit\Framework\TestCase;

class SchemaValidatorTest extends TestCase
{

    public const ORDER_PATTERN = [
        'orderTotal' => ':isFloat',
        'currency' => ':isString',
        'purchaseDate' => ':dateFormat',
        'orderSubtotal' => ':isFloat',
        'products' =>  [
            '*' => [
                'name' => ':isString',
                'price' => ':isFloat',
                'sku' => ':isString',
                'qty' => ':isInt',
            ]
        ]
    ];

    /**
     * @var SchemaValidatorRuleSetFactory
     */
    private $schemaOrderValidatorRuleSetFactory;

    /**
     * @var SchemaValidator
     */
    private $schemaOrderValidator;

    /**
     * @throws \Dotdigitalgroup\Email\Model\Validator\Schema\Exception\RuleNotDefinedException
     */
    private function getRuleFactory($rule)
    {

        $dateFormatRuleFactory = $this->createMock(DateFormatRuleFactory::class);
        $dateFormatRuleFactory
            ->method('create')
            ->willReturn(new DateFormatRule());
        $isFloatRuleFactory = $this->createMock(IsFloatRuleFactory::class);
        $isFloatRuleFactory
            ->method('create')
            ->willReturn(new IsFloatRule());
        $isIntRuleFactory = $this->createMock(IsIntRuleFactory::class);
        $isIntRuleFactory
            ->method('create')
            ->willReturn(new IsIntRule());
        $isStringRuleFactory = $this->createMock(IsStringRuleFactory::class);
        $isStringRuleFactory
            ->method('create')
            ->willReturn(new IsStringRule());
        $requiredRuleFactory = $this->createMock(RequiredRuleFactory::class);
        $requiredRuleFactory
            ->method('create')
            ->willReturn(new RequiredRule());
        $urlRuleFactory = $this->createMock(UrlRuleFactory::class);
        $requiredRuleFactory
            ->method('create')
            ->willReturn(new UrlRule());

        return new SchemaValidatorRule(
            $dateFormatRuleFactory,
            $isFloatRuleFactory,
            $isIntRuleFactory,
            $isStringRuleFactory,
            $requiredRuleFactory,
            $urlRuleFactory,
            $rule
        );
    }

    /**
     * Prepare test classes for Order validation
     *
     * @return void
     */
    private function setUpOrderValidator()
    {
        $this->schemaOrderValidatorRuleSetFactory = $this->createMock(SchemaValidatorRuleSetFactory::class);
        $schemaOrderValidatorRuleMockFactory = $this->createMock(SchemaValidatorRuleFactory::class);
        $schemaOrderValidatorRuleMockFactory->expects($this->exactly(8))
            ->method('create')
            ->withConsecutive(
                [["pattern" =>'isFloat']],
                [["pattern" =>'isString']],
                [["pattern" =>'dateFormat']],
                [["pattern" =>'isFloat']],
                [["pattern" =>'isString']],
                [["pattern" =>'isFloat']],
                [["pattern" =>'isString']],
                [["pattern" =>'isInt']]
            )
            ->will(
                $this->onConsecutiveCalls(
                    $this->getRuleFactory('isFloat'),
                    $this->getRuleFactory('isString'),
                    $this->getRuleFactory('dateFormat'),
                    $this->getRuleFactory('isFloat'),
                    $this->getRuleFactory('isString'),
                    $this->getRuleFactory('isFloat'),
                    $this->getRuleFactory('isString'),
                    $this->getRuleFactory('isInt')
                )
            );
        $this->schemaOrderValidatorRuleSetFactory->expects($this->exactly(10))
            ->method('create')
            ->withConsecutive(
                [["key" =>'orderTotal']],
                [["key" =>'currency']],
                [["key" =>'purchaseDate']],
                [["key" =>'orderSubtotal']],
                [["key" =>'products']],
                [["key" =>'products.*']],
                [["key" =>'products.*.name']],
                [["key" =>'products.*.price']],
                [["key" =>'products.*.sku']],
                [["key" =>'products.*.qty']]
            )
            ->will(
                $this->onConsecutiveCalls(
                    new SchemaValidatorRuleSet($schemaOrderValidatorRuleMockFactory),
                    new SchemaValidatorRuleSet($schemaOrderValidatorRuleMockFactory),
                    new SchemaValidatorRuleSet($schemaOrderValidatorRuleMockFactory),
                    new SchemaValidatorRuleSet($schemaOrderValidatorRuleMockFactory),
                    new SchemaValidatorRuleSet($schemaOrderValidatorRuleMockFactory),
                    new SchemaValidatorRuleSet($schemaOrderValidatorRuleMockFactory),
                    new SchemaValidatorRuleSet($schemaOrderValidatorRuleMockFactory),
                    new SchemaValidatorRuleSet($schemaOrderValidatorRuleMockFactory),
                    new SchemaValidatorRuleSet($schemaOrderValidatorRuleMockFactory),
                    new SchemaValidatorRuleSet($schemaOrderValidatorRuleMockFactory)
                )
            );
    }

    /**
     * Prepare test for run
     *
     * @return void
     * @throws \Dotdigitalgroup\Email\Model\Validator\Schema\Exception\PatternInvalidException
     * @throws \Dotdigitalgroup\Email\Model\Validator\Schema\Exception\RuleNotDefinedException
     */
    protected function setUp() :void
    {

        $this->setUpOrderValidator();
        $this->schemaOrderValidator = new SchemaValidator(
            $this->schemaOrderValidatorRuleSetFactory,
            static::ORDER_PATTERN
        );
    }

    /**
     * Test Valid Order
     *
     * @throws \Dotdigitalgroup\Email\Model\Validator\Schema\Exception\RuleNotDefinedException
     * @throws \Dotdigitalgroup\Email\Model\Validator\Schema\Exception\PatternInvalidException
     */
    public function testPatternMatchIsValid()
    {
        $this->schemaOrderValidator->isValid([
            'orderTotal' => 2.12,
            'currency' => 'USD',
            'purchaseDate' => '2022-05-20 14:43:11',
            'orderSubtotal' => 3.66,
            'products' => [
                [
                    'name' => 'mock_product_name',
                    'price' => 0.45,
                    'sku' => 'mock_product_name',
                    'qty' => (int) 5
                ]
            ]
        ]);
        $this->assertEmpty($this->schemaOrderValidator->getErrors());
    }

    /**
     * Test Valid Order
     *
     * @throws \Dotdigitalgroup\Email\Model\Validator\Schema\Exception\RuleNotDefinedException
     * @throws \Dotdigitalgroup\Email\Model\Validator\Schema\Exception\PatternInvalidException
     */
    public function testPatternMatchIsNotValid()
    {
        $this->schemaOrderValidator->isValid([
            'orderTotal' => "2.12",
            'currency' => null,
            'purchaseDate' => '2022-05-20 14:43:11',
            'orderSubtotal' => "3.66",
            'products' => [
                [
                    'name' => 'mock_product_name',
                    'price' => "0.45",
                    'sku' => 'mock_product_name',
                    'qty' => "5"
                ]
            ]
        ]);
        $this->assertNotEmpty($this->schemaOrderValidator->getErrors());
        $this->assertIsArray($this->schemaOrderValidator->getErrors());
        $this->assertArrayHasKey('orderTotal', $this->schemaOrderValidator->getErrors());
        $this->assertArrayHasKey('orderSubtotal', $this->schemaOrderValidator->getErrors());
        $this->assertArrayHasKey('currency', $this->schemaOrderValidator->getErrors());
        $this->assertArrayHasKey('products.*.price', $this->schemaOrderValidator->getErrors());
        $this->assertArrayHasKey('products.*.qty', $this->schemaOrderValidator->getErrors());
    }
}
