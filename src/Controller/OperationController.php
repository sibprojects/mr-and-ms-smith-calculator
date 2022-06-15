<?php

namespace App\Controller;

use App\Classes\Calculator\Calculator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OperationController extends AbstractController
{
    #[Route('/calc/operation', name: 'calcOperation')]
    public function index(Request $request, Calculator $calculator): JsonResponse
    {
        $calculator->setOperands([
            $request->get('val1', null),
            $request->get('val2', null),
        ]);
        $operation = 'App\Classes\Calculator\Operations\\' . $request->get('operation');
        $calculator->setOperation(new $operation);
        $result = $calculator->process();

        return new JsonResponse([
            'result' => $result,
        ]);
    }
}
