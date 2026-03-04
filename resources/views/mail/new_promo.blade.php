<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <title>Welcome to the Freshking7 Family!</title>
    <!-- Fonts -->
    <link href="https://fonts.bunny.net" rel="preconnect" />
    <link href="https://fonts.bunny.net/css?family=albert-sans" rel="stylesheet">
    <link href="{{ asset('assets/img/logo-anyar.png') }}" rel="icon" type="image/png" />

    @vite(['resources/css/app.css'])
    <style>
        body {
            font-family: 'Albert Sans', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif;
        }
    </style>
    </link>
</head>

<body style=" background-color: white; font-smoothing: antialiased;">
    <div
        style=" min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; background-color: white;">
        <div
            style=" width: 100%; max-width: 32rem; margin-left: auto; margin-right: auto; border: none; border-radius: 0.5rem; box-shadow: none; background-color: white;">
            <div
                style=" border-top-width: 8px; border-bottom-width: 8px; border-color: #d70a0a; border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem; border-bottom-left-radius: 0.5rem; border-bottom-right-radius: 0.5rem;">
                <div style=" padding-left: 2rem; padding-right: 2rem; padding-top: 2.5rem; padding-bottom: 2.5rem;">
                    <img alt="Engine Motech Accelerator Logo" src="{{ $message->embed(public_path('assets/img/logo-anyar.png')) }}" style="height: 4rem; margin-bottom: 1rem;" />
                    <h1 style=" font-size: 1.5rem; font-weight: bold;">🎉 {{ $promo->nama }}</h1>
                    @if ($promo->deskripsi)
                        <p>{!! $promo->deskripsi !!}</p>
                    @endif
                    {{-- Produk Info --}}
                    <div style="border-top: 1px solid #e5e7eb; padding-top: 1rem; margin-top: 1rem;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827; margin-bottom: 0.25rem;">
                            🎁 Produk Unggulan:  {{ $promo->produk->nama_produk }}
                        </h3>
                        <p style="color: #374151; font-size: 0.95rem; margin-bottom: 0.5rem;">
                            <strong>Deskripsi: {!! $promo->produk->deskripsi !!}</strong>
                        </p>
                        <p style="color: #374151; font-size: 0.95rem; margin-bottom: 0.5rem;">
                            <strong>Spesifikasi:</strong>
                        </p>
                        <ul>
                            @foreach ($promo->produk->spesifikasi as $spesifikasi)
                                <li>{{ $spesifikasi['nama'] }}: {{ $spesifikasi['nilai'] }}</li>
                            @endforeach
                        </ul>
                        <p>
                        <a href="{{ url('/produk/'.$promo->produk->id) }}" style="color: #2563eb; text-decoration: underline;">
                                👉 Lihat Produk
                            </a>
                        </p>
                    </div>


                    {{-- Masa Promo --}}
                    <div style="background-color: #fef3c7; padding: 1rem; margin-top: 1.5rem; border-radius: 0.375rem;">
                        <p style="color: #92400e; font-weight: 500; font-size: 0.95rem;">
                            Promo berlaku hingga:
                            <strong>{{ \Carbon\Carbon::parse($promo->masa_promo)->translatedFormat('d F Y, H:i') }}</strong>
                        </p>
                    </div>

                    {{-- CTA Button --}}
                    <div style="text-align: center; margin-top: 1.5rem;">
                        <a href="{{ url('/#promo') }}"
                            style="background-color: #10b981; color: white; padding: 0.75rem 1.5rem; font-size: 1rem; font-weight: 600; text-decoration: none; border-radius: 0.375rem; display: inline-block;">
                            🎯 Cek Promo Sekarang
                        </a>
                    </div>

                    {{-- Foitem?.marketplaceoter --}}
                    <p style="font-size: 0.875rem; color: #6b7280; margin-top: 2rem; text-align: center;">
                        Terima kasih telah menjadi bagian dari komunitas kami.
                        <br />
                        {{-- Jika Anda tidak ingin menerima email promo seperti ini lagi, <a href="#"
                            style="color: #ef4444; text-decoration: underline;">klik di sini</a> untuk berhenti
                        berlangganan. --}}
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>