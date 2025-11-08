<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url; // [00:21:30] Import URL attribute
use Stripe; // [00:21:58] Import Stripe

#[Title('Success - DCodeMania')] 
class SuccessPage extends Component
{ 
    // [00:21:20] Ambil 'session_id' dari query parameter URL
    #[Url]
    public $session_id;

    public function render()
    {
        // [00:21:42] Cek jika session_id ada di URL
        if ($this->session_id) {
            
            // [00:21:58] Set Stripe API Key
            Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
            
            // [00:22:20] Ambil detail sesi checkout dari Stripe
            $session_info = Stripe\Checkout\Session::retrieve($this->session_id);

            // [00:23:51] Cek status pembayaran
            if ($session_info->payment_status != 'paid') {
                // [00:24:15] Jika tidak 'paid', update status jadi 'failed'
                $latest_order = Order::where('user_id', auth()->id())->latest()->first();
                $latest_order->payment_status = 'failed';
                $latest_order->save(); // [00:24:28]
                return redirect()->route('cancel'); // [00:24:39] Redirect ke halaman 'cancel'
            
            } else if ($session_info->payment_status == 'paid') {
                // [00:24:58] Jika 'paid', update status jadi 'paid'
                $latest_order = Order::where('user_id', auth()->id())->latest()->first();
                $latest_order->payment_status = 'paid'; // [00:25:20]
                $latest_order->save(); // [00:25:20]
            }
        }

        // [00:11:40] Ambil data pesanan terbaru (setelah di-update statusnya)
        $latest_order = Order::with('address')
                            ->where('user_id', auth()->id())
                            ->latest()
                            ->first();

        return view('livewire.success-page', [
            'order' => $latest_order
        ]);
    }
}