<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $statusFilter = $request->query('status');
        $searchQuery = $request->query('search');

        $query = Order::with('customer');

        if ($statusFilter && in_array($statusFilter, ['Baru', 'Diproses', 'Selesai', 'Diambil'])) {
            $query->where('order_status', $statusFilter);
        }

        if ($searchQuery) {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('id', $searchQuery)
                  ->orWhereHas('customer', function ($cq) use ($searchQuery) {
                      $cq->where('name', 'like', '%' . $searchQuery . '%')
                         ->orWhere('phone', 'like', '%' . $searchQuery . '%');
                  });
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total' => Order::count(),
            'revenue' => Order::sum('total_price'),
            'baru' => Order::where('order_status', 'Baru')->count(),
            'diproses' => Order::where('order_status', 'Diproses')->count(),
            'selesai' => Order::where('order_status', 'Selesai')->count(),
            'diambil' => Order::where('order_status', 'Diambil')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats', 'statusFilter', 'searchQuery'));
    }

    public function show(Order $order)
    {
        $order->load('customer');
        return view('admin.orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $order->load('customer');
        $prices = $this->prices();
        return view('admin.orders.edit', compact('order', 'prices'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'service_type' => ['required', Rule::in(array_keys($this->prices()))],
            'weight' => 'required|numeric|min:0.5',
            'order_status' => ['required', Rule::in(['Baru', 'Diproses', 'Selesai', 'Diambil'])],
            'order_date' => 'required|date',
            'payment_proof' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->filled('name') || $request->filled('phone') || $request->filled('address')) {
            $order->customer->update(array_filter([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
            ]));
        }

        $updateData = [
            'service_type' => $request->service_type,
            'weight' => $request->weight,
            'total_price' => $this->calculateTotal($request->service_type, $request->weight),
            'order_status' => $request->order_status,
            'order_date' => $request->order_date,
        ];

        if ($request->hasFile('payment_proof')) {
            if ($order->payment_proof) {
                Storage::disk('public')->delete($order->payment_proof);
            }
            $updateData['payment_proof'] = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        $order->update($updateData);

        return redirect()->route('admin.dashboard')->with('success', 'Data pesanan #' . $order->id . ' berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        if ($order->payment_proof) {
            Storage::disk('public')->delete($order->payment_proof);
        }

        $order->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Pesanan #' . $order->id . ' berhasil dihapus.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => ['required', Rule::in(['Baru', 'Diproses', 'Selesai', 'Diambil'])],
        ]);
        $order->update(['order_status' => $request->order_status]);
        return redirect()->back()->with('success', 'Status pesanan #' . $order->id . ' berhasil diperbarui ke "' . $request->order_status . '".');
    }

    private function calculateTotal($serviceType, $weight)
    {
        return $this->prices()[$serviceType] * $weight;
    }

    private function prices()
    {
        return [
            'Cuci Kering' => 12000,
            'Cuci Setrika' => 15000,
            'Cuci Basah' => 10000,
        ];
    }
}
