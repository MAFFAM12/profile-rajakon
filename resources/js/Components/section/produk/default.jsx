import React, { useState } from 'react';
import { Section } from '../../ui/section';
import { Link } from '@inertiajs/react';

const ProdukCard = ({ produk, index }) => {
    const isEven = index % 2 === 0;
    const firstImage = produk.gambar?.[0]
        ? `/storage/${produk.gambar[0]}`
        : null;

    return (
        <div
            className={`flex flex-col ${isEven ? 'md:flex-row' : 'md:flex-row-reverse'} 
                items-center gap-10 md:gap-16 mb-24 last:mb-0 
                animate-appear opacity-0 w-full`}
            style={{ animationDelay: `${index * 100}ms` }}
        >
            {/* Teks */}
            <div className="flex-1 w-full">
                <span className="inline-block border border-blue-500 text-blue-500 text-xs font-semibold px-3 py-1 rounded-full mb-5 tracking-wide uppercase">
                    {produk.badge ?? 'Produk'}
                </span>

                <h3 className="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4 leading-tight">
                    {produk.nama}
                </h3>

                <p className="text-gray-600 dark:text-gray-400 mb-5 leading-relaxed text-base">
                    {produk.deskripsi?.length > 220
                        ? produk.deskripsi.slice(0, 220) + '...'
                        : produk.deskripsi}
                </p>

                {produk.manfaat?.length > 0 && (
                    <div className="mb-6">
                        <p className="font-semibold text-gray-800 dark:text-gray-200 mb-2 text-sm">
                            Manfaat {produk.nama}:
                        </p>
                        <ul className="text-gray-600 dark:text-gray-400 space-y-1 text-sm">
                            {produk.manfaat.slice(0, 2).map((m, i) => (
                                <li key={i} className="flex items-start gap-2">
                                    <span className="mt-1.5 w-1.5 h-1.5 rounded-full bg-blue-500 shrink-0" />
                                    {m.item ?? m}
                                </li>
                            ))}
                        </ul>
                    </div>
                )}

                <Link
                    href={`/produk/${produk.slug}`}
                    className="inline-flex items-center gap-1.5 text-blue-600 dark:text-blue-400 font-medium text-sm hover:gap-3 transition-all duration-200"
                >
                    Lihat produk
                    <svg xmlns="http://www.w3.org/2000/svg" className="w-4 h-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                        <path strokeLinecap="round" strokeLinejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </Link>
            </div>

            {/* Gambar */}
            <div className="flex-1 w-full">
                <div className="relative rounded-2xl overflow-hidden bg-zinc-800 aspect-[4/3] shadow-xl group">
                    {firstImage ? (
                        <img
                            src={firstImage}
                            alt={produk.nama}
                            className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        />
                    ) : (
                        <div className="w-full h-full flex items-center justify-center text-zinc-500 text-sm">
                            Belum ada gambar
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
};

const Produk = ({ produks = [] }) => {
    return (
        <Section id="produk">
            <div
                className="max-w-container mx-auto flex flex-col items-center gap-6 sm:gap-20">
                <div className="max-w-7xl mx-auto w-full">
                    {/* Header */}
                    <div className="text-left md:text-center mb-16">
                        <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4 animate-appear">
                            Produk Dan Jasa
                        </h2>
                        <p className="text-md md:text-lg text-gray-600 max-w-3xl mx-auto animate-appear opacity-0 delay-75">
                            Solusi terbaik yang kami tawarkan untuk kebutuhan Anda.
                        </p>
                    </div>

                    {/* List Produk */}
                    {produks.length === 0 ? (
                        <p className="text-center text-gray-400">Belum ada produk yang ditambahkan.</p>
                    ) : (
                        produks.map((produk, index) => (
                            <ProdukCard key={produk.id} produk={produk} index={index} />
                        ))
                    )}
                </div>
            </div>
        </Section>
    );
};

export default Produk;