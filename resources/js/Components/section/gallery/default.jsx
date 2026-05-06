import React, { useState, useEffect } from 'react';
import { FaChevronLeft, FaChevronRight, FaTimes } from 'react-icons/fa';
import { Section } from '../../ui/section';
import { WhenVisible } from '@inertiajs/react';
import { Button } from '../../ui/button';

const ITEMS_PER_PAGE = 10;
const appUrl = import.meta.env.VITE_APP_URL || 'http://localhost:8000';

const Gallery = () => {
	const [page, setPage] = useState(1);
	const [results, setResults] = useState([]);
	const [totalPage, setTotalPage] = useState(0);
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

	const getList = async () => {
		try {
			let response = await axios.get(`${appUrl}/api/gallery`, {
				headers: {
					'Content-Type': 'application/json'
				},
			})

			const { data, status } = response;

			if (data.success && status === 200) {
				setResults(data.results.data);
				setTotalPage(data.results.last_page);
			}
			console.log(response);
		} catch (error) {
			console.error(error.message);
		}
	}

	const loadMore = async () => {
		try {
			let response = await axios.get(`${appUrl}/api/gallery`, {
				headers: {
					'Content-Type': 'application/json'
				},
			})

			const { data, status } = response;

			if (data.success && status === 200) {
				setResults([...results, ...data.results.data]);
				setPage(page + 1);
			}
			console.log(response);
		} catch (error) {
			console.error(error.message);
		}
	}

	useEffect(() => {
		getList();
	}, [])

	return (
		<Section id="dokumentasi">
			<div className="max-w-container mx-auto flex flex-col items-center gap-6 sm:gap-20">
				<div className="max-w-7xl mx-auto w-full">

					{/* Header */}
					<div className="text-left md:text-center mb-16">
						<h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4 animate-appear">
							Dokumentasi
						</h2>
						<p className="text-md md:text-lg text-gray-600 max-w-3xl mx-auto animate-appear opacity-0 delay-75">
							Dokumentasi dari kegiatan dan pekerjaan yang kami lakukan di lapangan.
						</p>
					</div>

					{/* Gallery Grid */}
					{results.length === 0 ? (
						<p className="text-center text-gray-400 p-4 bg-gray-200 rounded-xl">Belum ada dokumentasi yang ditambahkan.</p>
					) : (
						<WhenVisible data={["results"]} fallback={() => (
							<div className='text-center'>
								<p>Loading...</p>
							</div>
						)}>
							<div className="columns-1 sm:columns-2 lg:columns-3 gap-4 space-y-4 animate-appear opacity-0 duration-300">
								{results.map((item, index) => (
									<div
										key={item.id}
										className="break-inside-avoid cursor-pointer overflow-hidden rounded-xl relative group animate-appear"
										onClick={() => setSelectedIndex(startIndex + index)}
									>
										<img
											className="w-full h-auto object-cover rounded-xl bg-gray-100 group-hover:scale-105 transition-transform duration-500"
											src={item.image}
											alt={item.title ?? 'Gallery'}
										/>

										{/* Hover Overlay dengan Judul */}
										{item.title && (
											<div className="absolute inset-0 rounded-xl bg-gradient-to-t from-black/70 via-black/20 to-transparent 
											opacity-0 group-hover:opacity-100 transition-all duration-300 
											flex flex-col justify-end p-4">
												<div className="translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
													{item.year && (
														<span className="text-white/60 text-xs font-medium tracking-widest uppercase mb-1 block">
															{item.year}
														</span>
													)}
													<p className="text-white font-semibold text-sm leading-snug drop-shadow">
														{item.title}
													</p>
												</div>
											</div>
										)}
									</div>
								))}
							</div>

							{
								page < totalPage ? (
									<div className="flex items-center justify-center mt-8">
										<Button onClick={loadMore}>Lihat Lainnya</Button>
									</div>
								) : null
							}
						</WhenVisible>
					)}
				</div>

				{/* IMAGE PREVIEW MODAL */}
				{selectedIndex !== null && (
					<div
						className="fixed inset-0 bg-black/95 flex items-center justify-center z-50"
						onClick={closePreview}
					>
						<div
							className="relative flex flex-col items-center justify-center px-16 max-w-5xl w-full"
							onClick={(e) => e.stopPropagation()}
						>
							{/* Close */}
							<button
								onClick={closePreview}
								className="absolute -top-12 right-0 text-white/70 hover:text-white text-2xl hover:scale-110 transition"
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
								className="max-h-[78vh] max-w-[90vw] rounded-xl shadow-2xl object-contain"
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
		</Section>
	);
};

export default Gallery;