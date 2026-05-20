import React from 'react';
import { Head, Link } from '@inertiajs/react';
import Layout from '../Layouts/Layout';
import DOMPurify from 'dompurify';

const BlogDetail = ({ blog, related = [] }) => {
    if (!blog) {
        return (
            <Layout>
                <main className="relative z-10 py-20 px-6">
                    <div className="max-w-7xl mx-auto w-full">
                        <p className="text-center text-zinc-500">Blog tidak ditemukan.</p>
                    </div>
                </main>
            </Layout>
        );
    }

    return (
        <Layout>
            <Head title={`${blog.judul} - Rajakon`} />

            <main className="relative z-10 py-20 px-6">
                <div className="max-w-7xl mx-auto w-full">

                    {/* Breadcrumb */}
                    <nav className="flex items-center gap-2 text-sm text-zinc-500 mb-8">
                        <Link href="/" className="hover:text-zinc-800 transition">Beranda</Link>
                        <span>/</span>
                        <Link href="/blog" className="hover:text-zinc-800 transition">Blog</Link>
                        <span>/</span>
                        <span className="text-zinc-800 dark:text-zinc-200 line-clamp-2">{blog.judul}</span>
                    </nav>

                    {/* Meta */}
                    <div className="flex items-center gap-3 mb-5">
                        {blog.kategori && (
                            <span className="text-xs font-semibold text-blue-600 dark:text-blue-400 bg-blue-50 dark:bg-blue-900/30 px-3 py-1 rounded-full">
                                {blog.kategori}
                            </span>
                        )}
                        {blog.published_at && (
                            <span className="text-sm text-zinc-400">{blog.published_at}</span>
                        )}
                    </div>

                    {/* Judul */}
                    <h1 className="text-3xl md:text-4xl font-bold text-zinc-900 dark:text-white mb-6 leading-tight">
                        {blog.judul}
                    </h1>

                    {/* Excerpt */}
                    {blog.excerpt && (
                        <p className="text-lg text-zinc-500 dark:text-zinc-400 mb-8 leading-relaxed border-l-4 border-blue-500 pl-4">
                            {blog.excerpt}
                        </p>
                    )}

                    {/* Thumbnail */}
                    {blog.thumbnail && (
                        <div className="rounded-2xl overflow-hidden mb-10 aspect-[16/9] bg-zinc-100">
                            <img
                                src={blog.thumbnail}
                                alt={blog.judul}
                                className="w-full h-full object-cover"
                            />
                        </div>
                    )}

                    {/* Konten */}
                    {blog.konten && (
                        <div
                            className="prose prose-zinc dark:prose-invert max-w-none
                                prose-headings:font-bold prose-headings:text-zinc-900 dark:prose-headings:text-white
                                prose-p:text-zinc-600 dark:prose-p:text-zinc-400 prose-p:leading-relaxed
                                prose-a:text-blue-600 dark:prose-a:text-blue-400 prose-a:no-underline hover:prose-a:underline
                                prose-img:rounded-xl prose-img:shadow-md
                                prose-blockquote:border-blue-500 prose-blockquote:text-zinc-600 dark:prose-blockquote:text-zinc-400
                                prose-code:bg-zinc-100 dark:prose-code:bg-zinc-800 prose-code:px-1.5 prose-code:rounded prose-code:text-zinc-900 dark:prose-code:text-zinc-100"
                            dangerouslySetInnerHTML={{ __html: DOMPurify.sanitize(blog.konten || '') }}
                        />
                    )}

                    {/* Back */}
                    <div className="mt-12 pt-8 border-t border-zinc-100 dark:border-zinc-800">
                        <Link
                            href="/blog"
                            className="inline-flex items-center gap-2 text-sm text-zinc-500 hover:text-zinc-800 transition"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" className="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
                                <path strokeLinecap="round" strokeLinejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali ke Blog
                        </Link>
                    </div>
                </div>

                {/* Artikel Terkait */}
                {related.length > 0 && (
                    <div className="max-w-7xl mx-auto mt-20">
                        <h2 className="text-2xl font-bold text-zinc-900 dark:text-white mb-8">
                            Artikel Terkait
                        </h2>
                        <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            {related.map((item) => (
                                <Link key={item.id} href={`/blog/${item.slug}`} className="group block">
                                    <div className="rounded-2xl overflow-hidden border border-zinc-100 dark:border-zinc-800 hover:shadow-lg transition-all duration-300">
                                        <div className="aspect-[16/9] bg-zinc-100 dark:bg-zinc-800 overflow-hidden">
                                            {item.thumbnail ? (
                                                <img src={item.thumbnail} alt={item.judul} className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                                            ) : (
                                                <div className="w-full h-full flex items-center justify-center text-zinc-400 text-xs">No image</div>
                                            )}
                                        </div>
                                        <div className="p-4">
                                            <p className="text-xs text-zinc-400 mb-1">{item.published_at}</p>
                                            <h3 className="font-semibold text-zinc-900 dark:text-white text-sm line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                {item.judul}
                                            </h3>
                                        </div>
                                    </div>
                                </Link>
                            ))}
                        </div>
                    </div>
                )}
            </main>
        </Layout>
    );
};

export default BlogDetail;