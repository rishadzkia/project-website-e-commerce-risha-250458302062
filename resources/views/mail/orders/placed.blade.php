<x-mail::message>
{{-- [00:04:00] Judul Email --}}
# Order Placed Successfully

{{-- [00:04:20] Isi Email --}}
Thank you for your order.

{{-- [00:04:30] Menampilkan Order ID --}}
Your order number is: {{ $order->id }}

{{-- [00:04:44] Tombol untuk melihat detail order --}}
<x-mail::button :url="$url">
View Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>