<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination; // Penting untuk pagination
use App\Models\Order; // Asumsi Anda punya model Order
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user yang login

class MyOrders extends Component
{
    // Menggunakan trait WithPagination agar bisa menggunakan $this->resetPage()
    // dan agar view-nya bisa menampilkan link pagination
    use WithPagination;

    // Menentukan tema pagination jika Anda menggunakan Bootstrap (opsional)
    // protected $paginationTheme = 'bootstrap';

    public function render()
    {
        // 1. Mengambil ID pengguna yang sedang login
        $userId = Auth::id();

        // 2. Mengambil data pesanan (Order) dari database
        //    - Hanya milik pengguna yang login (where('user_id', $userId))
        //    - Diurutkan dari yang terbaru (latest())
        //    - Dibagi per halaman (paginate(10)), misal 10 data per halaman
        $orders = Order::where('user_id', $userId)
            ->latest()
            ->paginate(10);

        // 3. Mengirim data 'orders' ke view
        return view('livewire.my-orders', [
            'orders' => $orders
        ]);
    }
}
