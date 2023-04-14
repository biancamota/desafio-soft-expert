<?php

namespace App\Controllers;

use App\Http\Response;
use App\Models\PaymentMethods as ModelsPaymentMethods;
use Exception;

class PaymentMethods
{
    protected $paymentMethodsModel;

    public function __construct()
    {
        $this->paymentMethodsModel = new ModelsPaymentMethods('payment_methods');
    }

    public function getAll()
    {
        try {
            $paymentMethods = $this->paymentMethodsModel->getAll();

            if (empty($paymentMethods)) {
                throw new Exception("No record found", 404);
            }

            return new Response([
                'success' => true,
                'data' => [
                    'paymentMethods' => $paymentMethods
                ]
            ]);
        } catch (\Throwable $th) {
            return new Response([
                'error' => $th->getCode(),
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }

    public function getById(int $id)
    {
        try {   
            $paymentMethod = $this->paymentMethodsModel->getById($id);

            if (empty($paymentMethod)) {
                throw new Exception("Payment method not found", 404);
            }
            return new Response([
                'success' => true,
                'data' => [
                    'paymentMethod' => $paymentMethod
                ]
            ]);
        } catch (\Throwable $th) {
            return new Response([
                'error' => $th->getCode(),
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }
}
