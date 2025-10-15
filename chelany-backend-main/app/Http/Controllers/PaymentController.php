<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\LiveEnvironment; 

class PaymentController extends Controller
{
    private $client;

    public function __construct()
    {
        $clientId = "AQBNJuDJGGqSofHpXJd2aRf8ww9l-oFordJizHvDlv03YCsrWAnHeRO1vyleORMS2dURI8HLfs-OoH0S";
        $clientSecret = 'services.paypal.AW_2kJ3tIRXNRwx4Q7VJit5jOvNI6bPXeYepTOghzl5wKw9x1LJzHkerNcpixk4yXMAJpmBV_wu4XCns';
        $environment = new LiveEnvironment($clientId, $clientSecret);
        $this->client = new PayPalHttpClient($environment);
    }

    public function createPayment(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1']);
    
        $order = new OrdersCreateRequest();
        $order->prefer('return=representation');
        $order->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [[
                'amount' => [
                    'currency_code' => 'EUR',
                    'value' => $request->amount
                ]
            ]],
            'application_context' => [
                'cancel_url' => route('payment.cancel'),
                'return_url' => route('payment.success')
            ]
        ];
    
        try {
            $response = $this->client->execute($order);
    
            foreach ($response->result->links as $link) {
                if ($link->rel === 'approve') {
                    // ✅ CORS safe response
                    return response()->json([
                        'success' => true,
                        'approval_url' => $link->href, // 👈 yeh frontend me use hoga
                        'paypal_order_id' => $response->result->id
                    ]);
                }
            }
    
            return response()->json(['error' => 'Approval URL not found']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    


    public function paymentSuccess(Request $request)
{
    $orderId = $request->get('token'); // PayPal ka Order ID

    $captureRequest = new OrdersCaptureRequest($orderId);
    $captureRequest->prefer('return=representation');

    try {
        $response = $this->client->execute($captureRequest);

        // 👇 Yahan se apni custom order ID generate kro (ya DB se lao agar DB use kar rahe ho)
        $customOrderId = 'ORD-' . strtoupper(uniqid()); // Example: "ORD-64DF1A2E4C4AB"

        return response()->json([
            'success' => true,
            'data' => $response->result,
            'order_id' => $customOrderId // 👈 Yeh line important hai
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()]);
    }
}

}