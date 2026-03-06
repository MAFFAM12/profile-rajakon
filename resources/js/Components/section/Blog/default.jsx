import React from 'react';
import { Link } from '@inertiajs/react';
import { Section } from '../../ui/section';

const BlogCard = ({ blog, index }) => {
    return (
        <Link
            href={`/blog/${blog.slug}`}
            className="group block animate-appear opacity-0"
            style={{ animationDelay: `${index * 100}ms` }}
        >
            <div className="rounded-2xl overflow-hidden bg-white dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800 shadow-sm hover:shadow-lg transition-all duration-300 h-full flex flex-col">

                {/* Thumbnail */}
                <div className="aspect-[16/9] overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                    {blog.thumbnail ? (
                        <img
                            src={blog.thumbnail}
                            alt={blog.judul}
                            className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        />
                    ) : (
                        <div className="w-full h-full flex items-center justify-center text-zinc-400 text-sm">
                            Tidak ada gambar
                        </div>
                    )}
                </div>

                {/* Konten */}
                <div className="p-5 flex flex-col flex-1">
                    <div className="flex items-center gap-2 mb-3">
                        {blog.kategori && (
                            <span className="text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-2 py-0.5 rounded-full">
                                {blog.kategori}
                            </span>
                        )}
                        {blog.published_at && (
                            <span className="text-xs text-zinc-400">
                                {blog.published_at}
                            </span>
                        )}
                    </div>

                    <h3 className="font-bold text-zinc-900 dark:text-white text-base leading-snug mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                        {blog.judul}
                    </h3>

                    {blog.excerpt && (
                        <p className="text-zinc-500 dark:text-zinc-400 text-sm leading-relaxed line-clamp-2 flex-1">
                            {blog.excerpt}
                        </p>
                    )}

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
};

const Blog = ({ blogs = [] }) => {
    if (blogs.length === 0) return null;

    return (
        <Section id="blog">
            <div className="max-w-6xl mx-auto">

                {/* Header */}
                <div className="flex items-end justify-between mb-12">
                    <div>
                        <h2 className="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white animate-appear">
                            Blog & Artikel
                        </h2>
                        <p className="text-gray-600 dark:text-gray-400 mt-2 animate-appear opacity-0 delay-75">
                            Informasi terbaru seputar layanan dan tips dari kami.
                        </p>
                    </div>
                    <Link
                        href="/blog"
                        className="hidden md:inline-flex items-center gap-1.5 text-sm font-medium text-blue-600 dark:text-blue-400 hover:gap-3 transition-all duration-200 shrink-0"
                    >
                        Lihat semua
                        <svg xmlns="http://www.w3.org/2000/svg" className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </Link>
                </div>

                {/* Grid 3 artikel */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {blogs.map((blog, index) => (
                        <BlogCard key={blog.id} blog={blog} index={index} />
                    ))}
                </div>

                {/* Tombol lihat semua - mobile */}
                <div className="mt-10 text-center md:hidden">
                    <Link
                        href="/blog"
                        className="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-zinc-200 dark:border-zinc-700 text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:border-blue-400 hover:text-blue-600 transition-all"
                    >
                        Lihat semua artikel
                        <svg xmlns="http://www.w3.org/2000/svg" className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                            <path strokeLinecap="round" strokeLinejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </Link>
                </div>
            </div>
        </Section>
    );
};

export default Blog;