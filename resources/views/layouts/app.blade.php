<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Seller Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <!-- LEFT SIDE: Logo + Nav Links -->
            <div class="flex items-center space-x-6">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="text-xl font-bold text-indigo-600">Seller Portal</a>

                @auth
                    @if(Auth::user()->role === 'admin')
                        <!-- Manage Sellers Dropdown -->
                        <div class="relative group">
                            <button class="px-4 py-2 text-indigo-600 hover:underline">
                                Manage Sellers
                            </button>
                            <div class="absolute left-0 mt-2 w-56 bg-white shadow-lg rounded z-10
                                        opacity-0 invisible group-hover:opacity-100 group-hover:visible
                                        transition-all duration-200 ease-in-out">
                                <a href="{{ route('admin.seller_applications.index') }}" 
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    Approve/Reject Sellers
                                </a>
                                <a href="{{ route('admin.seller_delete') }}" 
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    Delete Sellers Account
                                </a>
                            </div>
                        </div>

                        <!-- Manage Products Dropdown -->
                        <div class="relative group">
                            <button class="px-4 py-2 text-indigo-600 hover:underline">
                                Manage Products
                            </button>
                            <div class="absolute left-0 mt-2 w-56 bg-white shadow-lg rounded z-10
                                        opacity-0 invisible group-hover:opacity-100 group-hover:visible
                                        transition-all duration-200 ease-in-out">
                                <a href="{{ route('admin.products.index') }}" 
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    View Approved Products
                                </a>
                                <a href="{{ route('admin.product_applications.index') }}" 
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    Review Product Applications
                                </a>
                            </div>
                        </div>

                        <!-- Manage Orders Dropdown -->
                        <div class="relative group">
                            <button class="px-4 py-2 text-indigo-600 hover:underline">
                                Manage Orders
                            </button>
                            <div class="absolute left-0 mt-2 w-56 bg-white shadow-lg rounded z-10
                                        opacity-0 invisible group-hover:opacity-100 group-hover:visible
                                        transition-all duration-200 ease-in-out">
                                <a href="{{ route('admin.orders.index') }}" 
                                class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                    All Orders
                                </a>
                            </div>
                        </div>

                        <!-- Manage Payouts Dropdown -->
                        <a href="{{ route('admin.payouts.index') }}" class="px-4 py-2 text-indigo-600 hover:underline">
                            Payouts
                        </a>


                    @elseif(Auth::user()->role === 'seller')
                        <a href="{{ route('seller.dashboard') }}" class="px-4 py-2 text-indigo-600 hover:underline">
                        {{ __('Dashboard') }}
                        </a>
                        <a href="{{ route('seller.product_applications.index') }}" class="px-4 py-2 text-indigo-600 hover:underline">
                        {{ __('Products') }}
                        </a>
                        <a href="{{ route('seller.orders.index') }}" class="px-4 py-2 text-indigo-600 hover:underline">
                        {{ __('Orders') }}
                        </a>
                        <a href="{{ route('seller.payouts.index') }}" class="px-4 py-2 text-indigo-600 hover:underline">
                        {{ __('Payouts') }}
                        </a>
                    @endif
                @endauth
            </div>

            <!-- RIGHT SIDE: Auth Controls -->
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('seller.register') }}" class="px-4 py-2 text-indigo-600 hover:underline">Sellers, Register Here</a>
                    <a href="{{ route('login') }}" class="px-4 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700">Login</a>
                @endguest

                @auth
                    

                    <span class="mr-3">Hi, {{ Auth::user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        
                        <button type="submit" class="px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Page content -->
    <main class="container mx-auto px-4 py-6">
        @yield('content')
    </main>
</body>
</html>
