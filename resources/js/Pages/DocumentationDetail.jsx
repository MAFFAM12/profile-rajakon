import React, { useEffect, useState } from 'react'
import Layout from '../Layouts/Layout';
import { Head, WhenVisible } from '@inertiajs/react';
import { FaChevronLeft, FaChevronRight, FaTimes } from 'react-icons/fa';

const DocumentationDetail = ({ title, year, galleries }) => {
    const [selectedIndex, setSelectedIndex] = useState(null);

    // Guard clause for empty galleries
    if (!galleries || galleries.length === 0) {
        return (
            <Layout>
                <main className="relative py-8 px-6">
                    <div className="max-w-7xl mx-auto w-full">
                        <div className="text-center py-16">
                            <h2 className="text-3xl font-bold text-gray-900 mb-4">
                                Dokumentasi Tidak Ditemukan
                            </h2>
                            <p className="text-gray-600 mb-8">
                                Maaf, dokumentasi untuk "{title}" tahun {year} tidak tersedia.
                            </p>
                            <a
                                href="/dokumentasi"
                                className="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                            >
                                Kembali ke Dokumentasi
                            </a>
                        </div>
                    </div>
                </main>
            </Layout>
        );
    }

    const showPrevImage = () => {
        if (selectedIndex > 0) setSelectedIndex(selectedIndex - 1);
    };

    const showNextImage = () => {
        if (selectedIndex < galleries.length - 1) setSelectedIndex(selectedIndex + 1);
    };

    const closePreview = () => setSelectedIndex(null);

    useEffect(() => {
        const handleKeyDown = (e) => {
            if (e.key === 'Escape') closePreview();
            if (e.key === 'ArrowLeft') showPrevImage();
            if (e.key === 'ArrowRight') showNextImage();
        };

        if (selectedIndex !== null) {
            document.addEventListener('keydown', handleKeyDown);
            document.body.style.overflow = 'hidden';
        }

        return () => {
            document.removeEventListener('keydown', handleKeyDown);
            document.body.style.overflow = 'auto';
        };
    }, [selectedIndex]);

    return (
        <Layout>
            <Head title={`${galleries[0]?.title} - Rajakon`} />

            <main className="relative py-8 px-6">
                <div className="max-w-7xl mx-auto w-full">
                    {/* Header */}
                    <div className="text-left mb-16">
                        <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4 animate-appear">
                            {title}
                        </h2>
                        <p className="text-md md:text-lg text-gray-600 max-w-3xl animate-appear opacity-0 delay-75">
                            {year}
                        </p>
                    </div>

                    <WhenVisible data={[galleries]} fallback={() => (
                        <div className='text-center'>
                            <p>Loading...</p>
                        </div>
                    )}>
                        <div className='columns-1 sm:columns-2 lg:columns-3 gap-4 space-y-4 animate-appear opacity-0 duration-300'>
                            {galleries.map((item, index) => (
                                <div
                                    key={item.id}
                                    className="break-inside-avoid cursor-pointer overflow-hidden rounded-xl relative group animate-appear"
                                    onClick={() => setSelectedIndex(index)}
                                >
                                    <img
                                        className="w-full h-auto object-cover rounded-xl bg-gray-100 group-hover:scale-105 transition-transform duration-500"
                                        src={item.image}
                                        alt={item.title ?? 'Gallery'}
                                    />
                                </div>
                            ))}
                        </div>
                    </WhenVisible>

                    {/* IMAGE PREVIEW MODAL */}
                    {selectedIndex !== null && (
                        <div
                            className="fixed inset-0 bg-black/95 h-screen flex items-center justify-center z-50 overflow-hidden"
                            onClick={closePreview}
                        >
                            <div
                                className="relative w-full h-full flex flex-col items-center justify-center px-4 sm:px-8 md:px-16"
                                onClick={(e) => e.stopPropagation()}
                            >
                                {/* Close Button - Top Right */}
                                <button
                                    onClick={closePreview}
                                    className="absolute top-4 sm:top-6 right-4 sm:right-6 text-white/70 hover:text-white text-2xl hover:scale-110 transition z-10"
                                >
                                    <FaTimes />
                                </button>

                                {/* Previous Button - Left */}
                                <button
                                    onClick={showPrevImage}
                                    disabled={selectedIndex === 0}
                                    className="absolute left-4 sm:left-6 top-1/2 -translate-y-1/2 text-white/70 hover:text-white text-3xl hover:scale-110 disabled:opacity-20 transition z-10"
                                >
                                    <FaChevronLeft />
                                </button>

                                {/* Image Container */}
                                <div className="flex flex-col items-center justify-center max-w-5xl w-full">
                                    <img
                                        src={galleries[selectedIndex].image}
                                        alt={galleries[selectedIndex].title ?? ''}
                                        className="max-h-[70vh] sm:max-h-[75vh] md:max-h-[78vh] max-w-[95vw] sm:max-w-[90vw] rounded-xl shadow-2xl object-contain"
                                    />

                                    {/* Title & Meta */}
                                    <div className="mt-4 sm:mt-5 text-center px-4">
                                        {galleries[selectedIndex].title ? (
                                            <>
                                                <p className="text-white font-semibold text-base sm:text-lg md:text-xl tracking-wide">
                                                    {galleries[selectedIndex].title}
                                                </p>
                                                {galleries[selectedIndex].year && (
                                                    <p className="text-white/40 text-xs sm:text-sm mt-1 tracking-widest uppercase">
                                                        {galleries[selectedIndex].year}
                                                    </p>
                                                )}
                                            </>
                                        ) : (
                                            <p className="text-white/40 text-xs sm:text-sm tracking-widest">
                                                {selectedIndex + 1} / {galleries.length}
                                            </p>
                                        )}

                                        {/* Counter */}
                                        {galleries[selectedIndex].title && (
                                            <p className="text-white/30 text-xs mt-2">
                                                {selectedIndex + 1} / {galleries.length}
                                            </p>
                                        )}
                                    </div>
                                </div>

                                {/* Next Button - Right */}
                                <button
                                    onClick={showNextImage}
                                    disabled={selectedIndex === galleries.length - 1}
                                    className="absolute right-4 sm:right-6 top-1/2 -translate-y-1/2 text-white/70 hover:text-white text-3xl hover:scale-110 disabled:opacity-20 transition z-10"
                                >
                                    <FaChevronRight />
                                </button>
                            </div>
                        </div>
                    )}
                </div>
            </main>
        </Layout>
    );
}

export default DocumentationDetail