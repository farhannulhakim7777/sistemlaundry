<?php
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

try {
    $order = DB::transaction(function () {
        $customer = Customer::updateOrCreate(
            ['phone' => '08123456789'],
            ['name' => 'Test User', 'address' => 'Jl. Test No.1']
        );

        return Order::create([
            'customer_id'  => $customer->id,
            'service_type' => 'Cuci Kering',
            'weight'       => 2,
            'total_price'  => 24000,
            'order_status' => 'Baru',
            'order_date'   => date('Y-m-d'),
        ]);
    });

    echo "SUCCESS: Order ID=" . $order->id . "\n";
    echo "Customer: " . $order->customer->name . "\n";
    echo "Service: " . $order->service_type . "\n";
    echo "Total: Rp " . number_format($order->total_price, 0, ',', '.') . "\n";

} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
