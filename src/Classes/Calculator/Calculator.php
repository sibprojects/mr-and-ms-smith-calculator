<?php

namespace App\Classes\Calculator;

class Calculator
{
    protected $operands = [];
    protected $precision = 10;

    public function setOperands(array $operands = [])
    {
        $this->operands = $operands;
    }

    public function addOperand($operand)
    {
        $this->operands[] = $operand;
    }

    public function setPrecision(float $precision)
    {
        $this->precision = $precision;
    }

    public function setOperation(OperationInterface $operation)
    {
        if(!($operation instanceof OperationInterface)) {
            throw new \Exception('Operation Class not found in available list!');
        }

        $this->operation = $operation;
    }

    public function process() : float
    {
        $result = $this->operation->calculate($this->operands);

        $result = round($result, $this->precision);

        return $result;
    }

}