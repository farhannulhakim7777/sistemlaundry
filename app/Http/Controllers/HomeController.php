<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    public function index()
    {
        $prices = $this->prices();
        return view('home', compact('prices'));
    }

    public function create()
    {
        $prices = $this->prices();
        return view('order.create', compact('prices'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'phone'         => 'required|string|max:20',
            'address'       => 'required|string|max:500',
            'service_type'  => ['required', Rule::in(array_keys($this->prices()))],
            'weight'        => 'required|numeric|min:0.5',
            'order_date'    => 'required|date',
            'payment_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $order = DB::transaction(function () use ($request, $validated) {
            // Upsert customer berdasarkan nomor telepon
            $customer = Customer::updateOrCreate(
                ['phone' => $validated['phone']],
                [
                    'name'    => $validated['name'],
                    'address' => $validated['address'],
                ]
            );

            $orderData = [
                'customer_id'  => $customer->id,
                'service_type' => $validated['service_type'],
                'weight'       => $validated['weight'],
                'total_price'  => $this->calculateTotal($validated['service_type'], $validated['weight']),
                'order_status' => 'Baru',
                'order_date'   => $validated['order_date'],
            ];

            if ($request->hasFile('payment_proof')) {
                $orderData['payment_proof'] = $request->file('payment_proof')
                    ->store('payment_proofs', 'public');
            }

            return Order::create($orderData);
        });

        // Jika admin yang input, arahkan ke dashboard
        if ($request->session()->has('admin_id')) {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Pesanan #' . $order->id . ' berhasil dibuat!');
        }

        // Pelanggan biasa → halaman sukses
        return redirect()->route('order.success', $order)
            ->with('success', 'Pesanan #' . $order->id . ' berhasil dibuat!');
    }

    public function success(Order $order)
    {
        $order->load('customer');
        return view('order.success', compact('order'));
    }

    public function trackForm(Request $request)
    {
        $query  = $request->query('query');
        $orders = collect();

        if ($query) {
            $orders = Order::with('customer')
                ->where('id', $query)
                ->orWhereHas('customer', function ($q) use ($query) {
                    $q->where('phone', 'like', '%' . $query . '%')
                      ->orWhere('name', 'like', '%' . $query . '%');
                })
                ->latest()
                ->get();
        }

        return view('order.track', compact('orders', 'query'));
    }

    public function trackSearch(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:255',
        ]);

        return redirect()->route('order.track', ['query' => $request->input('query')]);
    }

    private function calculateTotal(string $serviceType, float $weight): float
    {
        return $this->prices()[$serviceType] * $weight;
    }

    public function prices(): array
    {
        return [
            'Cuci Kering'  => 12000,
            'Cuci Setrika' => 15000,
            'Cuci Basah'   => 10000,
        ];
    }
}
