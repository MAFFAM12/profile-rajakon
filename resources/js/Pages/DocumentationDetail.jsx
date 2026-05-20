import React, { useEffect, useState } from 'react'
import Layout from '../Layouts/Layout';
import { Head, WhenVisible } from '@inertiajs/react';
import { FaChevronLeft, FaChevronRight, FaTimes } from 'react-icons/fa';

const DocumentationDetail = ({ title, year, galleries }) => {
    const [selectedIndex, setSelectedIndex] = useState(null);

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
                                className="relative flex flex-col items-center justify-center px-16 max-w-5xl w-full"
                                onClick={(e) => e.stopPropagation()}
                            >
                                {/* Close */}
                                <button
                                    onClick={closePreview}
                                    className="text-white/70 hover:text-white text-2xl hover:scale-110 transition"
                                >
                                    <FaTimes />
                                </button>

                                {/* Previous */}
                                <button
                                    onClick={showPrevImage}
                                    disabled={selectedIndex === 0}
                                    className="absolute left-0 text-white/70 hover:text-white text-3xl hover:scale-110 disabled:opacity-20 transition"
                                >
                                    <FaChevronLeft />
                                </button>

                                {/* Image */}
                                <img
                                    src={galleries[selectedIndex].image}
                                    alt={galleries[selectedIndex].title ?? ''}
                                    className="max-h-[78vh] max-w-[90vw] rounded-xl shadow-2xl object-contain mt-4"
                                />

                                {/* Title & Meta di bawah gambar */}
                                <div className="mt-5 text-center">
                                    {galleries[selectedIndex].title ? (
                                        <>
                                            <p className="text-white font-semibold text-lg tracking-wide">
                                                {galleries[selectedIndex].title}
                                            </p>
                                            {galleries[selectedIndex].year && (
                                                <p className="text-white/40 text-sm mt-1 tracking-widest uppercase">
                                                    {galleries[selectedIndex].year}
                                                </p>
                                            )}
                                        </>
                                    ) : (
                                        <p className="text-white/40 text-sm tracking-widest">
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

                                {/* Next */}
                                <button
                                    onClick={showNextImage}
                                    disabled={selectedIndex === galleries.length - 1}
                                    className="absolute right-0 text-white/70 hover:text-white text-3xl hover:scale-110 disabled:opacity-20 transition"
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