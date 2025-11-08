<div>
    {{-- Judul Halaman --}}
    <h2>Pesanan Saya</h2>
    <hr>

    {{-- Tabel untuk Menampilkan Data Pesanan --}}
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">No. Pesanan</th>
                <th scope="col">Tanggal</th>
                <th scope="col">Status</th>
                <th scope="col">Total Bayar</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            {{-- Loop untuk setiap pesanan --}}
            @forelse ($orders as $order) 
                <tr>
                    <td>{{ $order->tracking_no }}</td>
                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                    <td>{{ $order->status_message }}</td>
                    <td>Rp {{ number_format($order->total_price) }}</td>
                    <td>
                        <a href="{{-- url('orders/'.$order->id) --}}" class="btn btn-primary btn-sm">Lihat Detail</a>
                    </td>
                </tr>
            @empty
                {{-- Tampil jika tidak ada data pesanan --}}
                <tr>
                    <td colspan="5" class="text-center">Anda belum memiliki pesanan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Bagian untuk Link Pagination --}}
    <div class="mt-4">
        {{ $orders->links() }}
    </div>

</div>