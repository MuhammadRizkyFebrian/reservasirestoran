            <div class="mb-4">
                <h6 class="text-sm font-medium mb-2">Bukti Pembayaran</h6>
                @if($pemesanan->bukti_pembayaran)
                <img src="{{ asset('storage/bukti_pembayaran/' . $pemesanan->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="max-w-full h-auto rounded-lg">
                @else
                <p class="text-sm text-gray-500">Belum ada bukti pembayaran</p>
                @endif
            </div>