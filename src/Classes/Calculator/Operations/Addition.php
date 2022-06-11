<?php

namespace App\Classes\Calculator\Operations;

use App\Classes\Calculator\OperationInterface;

class Addition implements OperationInterface
{
    public function calculate(array $operands = []) : float
    {
        return array_sum($operands);
    }
}