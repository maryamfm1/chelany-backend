<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaypalService;
use PayPal\Api\Payment;
use PayPal\Api\Payer;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Amount;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;

class PaymentController extends Controller
{
    protected $paypal;

    public function __construct(PaypalService $paypal)
    {
        $this->paypal = $paypal->getApiContext();
    }

    // PayPal payment create karne ke liye
    public function createPayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);
        // yeh check karega k JSON body sahi mil rhi ya nahi
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new Amount();
        $amount->setTotal($request->amount);  // front-end se amount lena hoga
        $amount->setCurrency('EUR');

        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription('Payment description');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(route('payment.success'));
        $redirectUrls->setCancelUrl(route('payment.cancel'));

        $payment = new Payment();
$payment->setIntent('sale')  // ✅ 'sale' string sahi hai
        ->setPayer($payer)
        ->setRedirectUrls($redirectUrls)
        ->setTransactions([$transaction]);  // ✅ wrap in array


        try {
            $payment->create($this->paypal);
            return redirect()->away($payment->getApprovalLink());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    // Payment success hone par
    public function paymentSuccess(Request $request)
{
    $paymentId = $request->paymentId;
    $payerId = $request->PayerID;

    $payment = Payment::get($paymentId, $this->paypal);

    $execution = new PaymentExecution();
    $execution->setPayerId($payerId);

    try {
        $result = $payment->execute($execution, $this->paypal);
        return response()->json(['success' => true, 'result' => $result]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
}

}