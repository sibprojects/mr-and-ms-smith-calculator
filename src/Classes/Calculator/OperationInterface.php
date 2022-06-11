<?php

namespace App\Classes\Calculator;

interface OperationInterface
{
    public function calculate(array $operands = []) : float;
}