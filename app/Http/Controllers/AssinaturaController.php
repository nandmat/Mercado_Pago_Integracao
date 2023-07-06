<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\Preapproval;
use MercadoPago\SDK;

class AssinaturaController extends Controller
{
    public function criarAssinatura()
    {
        SDK::setAccessToken('APP_USR-49331451017500-070321-0a7bab4341785fd9d606aa2b6b8a4ff2-258027410');

        $preapproval = new Preapproval();

        $preapproval->payer_email = 'cliente@example.com';
        $preapproval->back_url = route('assinar.success');
        $preapproval->reason = 'Assinatura Mensal';
        $preapproval->external_reference = 'ID_ASSINATURA';
        $preapproval->auto_recurring = [
            'frequency' => 1,
            'frequency_type' => 'months',
            'transaction_amount' => 0.00, // O valor do plano será utilizado
            'currency_id' => 'BRL',
            'plan_id' => '2c938084891b1d1d01891e9cc4ac01ba' // Obtém o ID do plano do arquivo .env
        ];

        $preapproval->save();
        $paymentUrl = $preapproval->init_point;

        return redirect()->away($paymentUrl);
    }
}
