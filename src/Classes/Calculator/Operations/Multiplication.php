<?php

namespace App\Classes\Calculator\Operations;

use App\Classes\Calculator\OperationInterface;

class Multiplication implements OperationInterface
{
    public function calculate(array $operands = []) : float
    {
        $result = 0;
        reset($operands);
        foreach ($operands as $key => $val){
            if($key==0){
                $result = $val;
                continue;
            }
            $result *= $val;
        }
        return $result;
    }
}