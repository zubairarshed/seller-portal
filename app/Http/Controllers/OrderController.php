<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create()
    {
        $cart = session()->get('cart', []);

        // Check Inventory for each product before creating Order
        foreach ($cart as $productId => $item) {
            $product = Product::findOrFail($productId);

            if ($product->inventory < $item['quantity']) {
                return redirect()->route('cart.index')
                    ->with('error', "Not Enough stock for {$product->title}. Only {$product->inventory} left.");
            }
        }

        $cart = session()->get('cart', []);
        return view('checkout.index', compact('cart'));
    }

    /**
     * Store a new order (checkout)
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty!');
        }

        // ✅ validate buyer shipping info
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'required|string|max:20',
            'address' => 'required|string|max:500',
        ]);

        

        // Calculate total
        $grandTotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        // Create order
        $order = Order::create([
            'buyer_name'    => $data['name'],
            'buyer_email'   => $data['email'],
            'buyer_phone'   => $data['phone'],
            'shipping_address' => $data['address'],
            'total_price'   => $grandTotal,
            'status'  => 'pending'
        ]);

        // Create order items
        foreach ($cart as $productId => $item) {
            $orderItem = OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $productId,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
                'seller_id'  => $item['seller_id']
            ]);

            $product = Product::findOrFail($productId);
            
            // Deduct inventory
            $product->decrement('inventory', $orderItem->quantity);
        }

        // Clear the cart
        session()->forget('cart');

        // Redirect to order confirmation
        return redirect()->route('orders.show', $order)
            ->with('success', 'Your order has been placed successfully!');
    }


    /**
     * Show all orders for the buyer
     */
    public function index() {
        $orders = Order::with('items.product')->latest()->get();
        return view('orders.index', compact('orders'));
    }


    /**
     * Show single order details
     */
    public function show(Order $order) {
        $order->load('items.product', 'items.seller');  // Eager Loading Product and Seller
        return view('orders.show', compact('order'));
    }
}
