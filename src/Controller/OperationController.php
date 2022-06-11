<?php

namespace App\Controller;

use App\Classes\Calculator\Calculator;
use App\Classes\Calculator\Operations\Addition;
use App\Classes\Calculator\Operations\Division;
use App\Classes\Calculator\Operations\Multiplication;
use App\Classes\Calculator\Operations\Subtraction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OperationController extends AbstractController
{
    #[Route('/calc/operation', name: 'calcOperation')]
    public function index(Request $request, Calculator $calculator,
                          Addition $addition, Subtraction $subtraction,
                          Division $division, Multiplication $multiplication): JsonResponse
    {
        if($request->get('val1') === null){
            throw new \Exception('First number not found!');
        }
        if($request->get('val2') === null){
            throw new \Exception('Second number not found!');
        }
        if($request->get('operation') === null){
            throw new \Exception('Operation not found!');
        }

        $calculator->setOperands([
            $request->get('val1'),
            $request->get('val2'),
        ]);

        $calculator->setPrecision(10 );

        switch ($request->get('operation') ){
            case '+':
                $calculator->setOperation($addition);
                break;

            case '-':
                $calculator->setOperation($subtraction);
                break;

            case '*':
                $calculator->setOperation($multiplication);
                break;

            case '÷':
                $calculator->setOperation($division);
                break;

            default:
                throw new \Exception('Operation not found in available list!');
        }

        $result = $calculator->process();

        return new JsonResponse([
            'result' => $result,
        ]);
    }
}
