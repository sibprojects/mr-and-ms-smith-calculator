<?php

namespace App\Classes\Calculator\Operations;

use App\Classes\Calculator\OperationInterface;

class Division implements OperationInterface
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
            if($val==0){
                throw new \Exception('Division by zero!');
            }
            $result /= $val;
        }
        return $result;
    }
}