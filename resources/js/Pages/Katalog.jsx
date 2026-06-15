import React from 'react'
import Layout from '../Layouts/Layout'
import { Section } from '../Components/ui/section'
import { Head, Link, router } from '@inertiajs/react'

const Katalog = (props) => {
    const { produks, aktifKategori } = props;

    const { data, links, meta } = produks;

    const filterKategori = (kat) => {
        router.get('/katalog', kat ? { kategori: kat } : {}, { preserveState: true });
    };
    return (
        <Layout>
            <Head title="Rajakon - Katalog" />

            <main className="relative z-10 py-20 px-6">
                <div className="max-w-7xl mx-auto">
                    {/* Header */}
                    <div className="mb-12">
                        <nav className="flex items-center gap-2 text-sm text-zinc-500 mb-6">
                            <Link href="/" className="hover:text-zinc-800 transition">Beranda</Link>
                            <span>/</span>
                            <span className="text-zinc-800 dark:text-zinc-200">Katalog</span>
                        </nav>
                        <h1 className="text-4xl md:text-5xl font-bold text-zinc-900 dark:text-white mb-3">
                            Katalog
                        </h1>
                        <p className="text-zinc-500 dark:text-zinc-400 text-lg">
                            Informasi terbaru seputar produk dan jasa dari kami.
                        </p>
                    </div>

                    {/* Filter Kategori */}
                    <div className="flex flex-wrap gap-2 mb-10">
                        <button
                            onClick={() => filterKategori()}
                            className={`px-4 py-1.5 rounded-full text-sm font-medium transition-all ${!aktifKategori
                                ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900'
                                : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200'
                                }`}
                        >
                            Semua
                        </button>
                        <button
                            onClick={() => filterKategori('produk')}
                            className={`px-4 py-1.5 rounded-full text-sm font-medium transition-all ${aktifKategori === 'produk'
                                ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900'
                                : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200'
                                }`}
                        >
                            Produk
                        </button>
                        <button
                            onClick={() => filterKategori('jasa')}
                            className={`px-4 py-1.5 rounded-full text-sm font-medium transition-all ${aktifKategori === 'jasa'
                                ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900'
                                : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200'
                                }`}
                        >
                            Jasa
                        </button>
                    </div>

                    {/* Grid Artikel */}
                    {data.length === 0 ? (
                        <div className="text-center py-20 text-zinc-400">
                            Belum ada produk atau yang dipublikasikan.
                        </div>
                    ) : (
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                            {data.map((produk) => (
                                <ProdukCard key={produk.id} produk={produk} />
                            ))}
                        </div>
                    )}

                    {/* Pagination */}
                    {links && links.length > 3 && (
                        <div className="flex justify-center items-center gap-2 flex-wrap">
                            {links.map((link, i) => (
                                <button
                                    key={i}
                                    onClick={() => link.url && router.get(link.url)}
                                    disabled={!link.url}
                                    className={`px-4 py-2 rounded-lg text-sm transition-all ${link.active
                                        ? 'bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-semibold'
                                        : link.url
                                            ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-300 hover:bg-zinc-200'
                                            : 'opacity-30 cursor-not-allowed bg-zinc-100 dark:bg-zinc-800 text-zinc-400'
                                        }`}
                                    dangerouslySetInnerHTML={{ __html: link.label }}
                                />
                            ))}
                        </div>
                    )}
                </div>
            </main>
        </Layout>
    )
}

const ProdukCard = ({ produk }) => (
    <Link href={`/produk/${produk.slug}`} className="group block">
        <div className="rounded-2xl overflow-hidden bg-white dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800 shadow-sm hover:shadow-lg transition-all duration-300 h-full flex flex-col">
            <div className="aspect-[16/9] overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                {produk.gambar.length > 0 ? (
                    <img
                        src={`/storage/${produk.gambar[0]}`}
                        alt={produk.nama}
                        className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />
                ) : (
                    <div className="w-full h-full flex items-center justify-center text-zinc-400 text-sm">
                        Tidak ada gambar
                    </div>
                )}
            </div>
            <div className="p-5 flex flex-col flex-1">
                <div className="flex items-center gap-2 mb-3">
                    {produk.badge && (
                        <span className="text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-0.5 rounded-full">
                            {produk.badge}
                        </span>
                    )}
                    {produk.created_at && (
                        <span className="text-xs text-zinc-400">{produk.created_at}</span>
                    )}
                </div>
                <h3 className="font-bold text-zinc-900 dark:text-white text-base leading-snug mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                    {produk.nama}
                </h3>
                <div className="mt-4 flex items-center gap-1 text-blue-600 dark:text-blue-400 text-sm font-medium">
                    Baca selengkapnya
                    <svg xmlns="http://www.w3.org/2000/svg" className="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                        <path strokeLinecap="round" strokeLinejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </div>
    </Link>
);

export default Katalog