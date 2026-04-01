import React, { useState, useRef } from 'react';
import { Head, Link } from '@inertiajs/react';
import Layout from '../Layouts/Layout';
import DOMPurify from 'dompurify';

const ZoomImage = ({ src, alt }) => {
    const [zoomed, setZoomed] = useState(false);
    const [bgPos, setBgPos] = useState('50% 50%');
    const containerRef = useRef(null);

    const handleMouseMove = (e) => {
        const rect = containerRef.current.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width) * 100;
        const y = ((e.clientY - rect.top) / rect.height) * 100;
        setBgPos(`${x}% ${y}%`);
    };

    const handleMouseEnter = () => setZoomed(true);
    const handleMouseLeave = () => {
        setZoomed(false);
        setBgPos('50% 50%');
    };

    return (
        <div
            ref={containerRef}
            onMouseMove={handleMouseMove}
            onMouseEnter={handleMouseEnter}
            onMouseLeave={handleMouseLeave}
            className="relative rounded-2xl overflow-hidden aspect-[4/3] shadow-xl select-none"
            style={{ cursor: zoomed ? 'crosshair' : 'default' }}
        >
            {/* Gambar normal (hidden saat zoom) */}
            <img
                src={src}
                alt={alt}
                draggable={false}
                className={`w-full h-full object-cover transition-opacity duration-200 ${zoomed ? 'opacity-0' : 'opacity-100'}`}
            />

            {/* Zoom layer */}
            <div
                className={`absolute inset-0 transition-opacity duration-200 ${zoomed ? 'opacity-100' : 'opacity-0'}`}
                style={{
                    backgroundImage: `url(${src})`,
                    backgroundSize: '250%',
                    backgroundPosition: bgPos,
                    backgroundRepeat: 'no-repeat',
                }}
            />

            {/* Hint tooltip saat belum hover */}
            {!zoomed && (
                <div className="absolute bottom-3 right-3 bg-black/50 text-white text-xs px-2 py-1 rounded-full backdrop-blur-sm flex items-center gap-1 pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" className="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                    Arahkan untuk zoom
                </div>
            )}
        </div>
    );
};

const ProdukDetail = ({ produk }) => {
    const [activeImage, setActiveImage] = useState(0);

    const images = produk.gambar?.map(img => `/storage/${img}`) ?? [];

    return (
        <Layout>
            <Head title={`${produk.nama} - Rajakon`} />

            <main className="relative z-10 py-20 px-6">
                <div className="max-w-7xl mx-auto w-full">

                    {/* Breadcrumb */}
                    <nav className="flex items-center gap-2 text-sm text-gray-500 mb-10">
                        <Link href="/" className="hover:text-gray-800 transition">Beranda</Link>
                        <span>/</span>
                        <span className="text-gray-800 dark:text-gray-200">{produk.nama}</span>
                    </nav>

                    <div className="flex flex-col md:flex-row gap-12">

                        {/* Gallery */}
                        <div className="flex-1">
                            {/* Gambar Utama dengan Zoom */}
                            {images.length > 0 ? (
                                <ZoomImage
                                    src={images[activeImage]}
                                    alt={produk.nama}
                                />
                            ) : (
                                <div className="bg-zinc-800 rounded-2xl overflow-hidden aspect-[4/3] flex items-center justify-center text-zinc-500 text-sm">
                                    Belum ada gambar
                                </div>
                            )}

                            {/* Thumbnails */}
                            {images.length > 1 && (
                                <div className="flex gap-3 flex-wrap mt-4">
                                    {images.map((img, i) => (
                                        <button
                                            key={i}
                                            onClick={() => setActiveImage(i)}
                                            className={`w-20 h-16 rounded-xl overflow-hidden border-2 transition-all duration-200
                                                ${activeImage === i
                                                    ? 'border-blue-500 opacity-100'
                                                    : 'border-transparent opacity-60 hover:opacity-100'
                                                }`}
                                        >
                                            <img src={img} className="w-full h-full object-cover" alt="" draggable={false} />
                                        </button>
                                    ))}
                                </div>
                            )}
                        </div>

                        {/* Detail */}
                        <div className="flex-1">
                            <span className="inline-block border border-red-500 text-red-500 text-xs font-semibold px-3 py-1 rounded-full mb-4 tracking-wide uppercase">
                                {produk.badge ?? 'Produk'}
                            </span>

                            <h1 className="text-4xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                                {produk.nama}
                            </h1>

                            {produk.harga && (
                                <p className="text-xl font-bold text-gray-800 dark:text-gray-100 mb-6">
                                    Harga: Rp {Number(produk.harga).toLocaleString('id-ID')}
                                </p>
                            )}

                            <p className="text-gray-600 dark:text-gray-400 mb-6 leading-relaxed text-base">
                                <span
                                    className='prose text-[#57606a] dark:text-[#8b949e]'
                                    dangerouslySetInnerHTML={{
                                        __html: DOMPurify.sanitize(produk?.deskripsi || '')
                                    }}
                                />
                            </p>

                            {produk.manfaat?.length > 0 && (
                                <div className="mb-6">
                                    <p className="font-semibold text-gray-800 dark:text-gray-200 mb-3">
                                        Manfaat {produk.nama}:
                                    </p>
                                    <ul className="space-y-2">
                                        {produk.manfaat.map((m, i) => (
                                            <li key={i} className="flex items-start gap-2 text-gray-600 dark:text-gray-400 text-sm">
                                                <span className="mt-1.5 w-1.5 h-1.5 rounded-full bg-red-500 shrink-0" />
                                                {m.item ?? m}
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            )}

                            <Link
                                href="/"
                                className="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-800 transition mt-4"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" className="w-4 h-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                                Kembali ke beranda
                            </Link>
                        </div>
                    </div>
                </div>
            </main>
        </Layout>
    );
};

export default ProdukDetail;