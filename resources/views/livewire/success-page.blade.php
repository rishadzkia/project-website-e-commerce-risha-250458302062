<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
<section class="flex items-center font-poppins dark:bg-gray-800 ">
  <div class="justify-center flex-1 max-w-6xl px-4 py-4 mx-auto bg-white border rounded-md dark:border-gray-900 dark:bg-gray-900 md:py-10 md:px-10">
    <div>
      <h1 class="px-4 mb-8 text-2xl font-semibold tracking-wide text-gray-700 dark:text-gray-300">
        Thank you. Your order has been received.
      </h1>

      {{-- [00:13:46] Informasi Pelanggan --}}
      <div class="flex border-b border-gray-200 dark:border-gray-700 items-stretch justify-start w-full h-full px-4 mb-8 md:flex-row xl:flex-col md:space-x-6 lg:space-x-8 xl:space-x-0">
        <div class="flex items-start justify-start flex-shrink-0">
          <div class="flex items-center justify-center w-full pb-6 space-x-4 md:justify-start">
            <div class="flex flex-col items-start justify-start space-y-2">
              {{-- Nama Pelanggan --}}
              <h4 class="text-lg font-medium text-gray-800 dark:text-gray-400">
                {{ $order->address->full_name }}
              </h4>

              {{-- Alamat --}}
              <p class="text-sm leading-4 text-gray-600 dark:text-gray-400">
                {{ $order->address->street_address }}
              </p>
              <p class="text-sm leading-4 text-gray-600 dark:text-gray-400">
                {{ $order->address->city }}, {{ $order->address->state }}, {{ $order->address->zip_code }}
              </p>

              {{-- Telepon --}}
              <p class="text-sm leading-4 text-gray-600 dark:text-gray-400">
                Phone: {{ $order->address->phone }}
              </p>
            </div>
          </div>
        </div>
      </div>

      {{-- [00:15:10] Rincian Order --}}
      <div class="flex flex-wrap items-center pb-4 mb-10 border-b border-gray-200 dark:border-gray-700">
        <div class="w-full px-4 mb-4 md:w-1/4">
          <p class="mb-2 text-sm leading-5 text-gray-600 dark:text-gray-400">Order Number:</p>
          <p class="text-base font-semibold leading-4 text-gray-800 dark:text-gray-400">
            {{ $order->id }}
          </p>
        </div>

        <div class="w-full px-4 mb-4 md:w-1/4">
          <p class="mb-2 text-sm leading-5 text-gray-600 dark:text-gray-400">Date:</p>
          <p class="text-base font-semibold leading-4 text-gray-800 dark:text-gray-400">
            {{ $order->created_at->format('d M Y') }}
          </p>
        </div>

        <div class="w-full px-4 mb-4 md:w-1/4">
          <p class="mb-2 text-sm font-medium leading-5 text-gray-800 dark:text-gray-400">Total:</p>
          <p class="text-base font-semibold leading-4 text-blue-600 dark:text-gray-400">
            {{ Number::currency($order->grand_total, 'INR') }}
          </p>
        </div>

        <div class="w-full px-4 mb-4 md:w-1/4">
          <p class="mb-2 text-sm leading-5 text-gray-600 dark:text-gray-400">Payment Method:</p>
          <p class="text-base font-semibold leading-4 text-gray-800 dark:text-gray-400">
            @if ($order->payment_method == 'cod')
                Cash on Delivery
            @else
                Card
            @endif
          </p>
        </div>
      </div>

      {{-- [00:18:47] Tombol Navigasi --}}
      <div class="flex items-center justify-start gap-4 px-4 mt-6">
        <a href="{{ route('products') }}" class="w-full text-center px-4 py-2 text-blue-500 border border-blue-500 rounded-md md:w-auto hover:text-white hover:bg-blue-600 dark:border-gray-700 dark:hover:bg-gray-700 dark:text-gray-300">
          Go back shopping
        </a>
        <a href="{{ route('my-orders') }}" class="w-full text-center px-4 py-2 bg-blue-500 rounded-md text-gray-50 md:w-auto dark:text-gray-300 hover:bg-blue-600 dark:hover:bg-gray-700 dark:bg-gray-800">
          View My Orders
        </a>
      </div>
    </div>
  </div>
</section>
</div>
