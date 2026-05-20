import React, { useState, useEffect } from 'react';
import { Section } from '../../ui/section';
import { WhenVisible } from '@inertiajs/react';
import { Button } from '../../ui/button';

const ITEMS_PER_PAGE = 10;
const appUrl = import.meta.env.VITE_APP_URL || 'http://localhost:8000';

const Gallery = ({ galleries }) => {
	const [page, setPage] = useState(1);
	const [results, setResults] = useState([]);
	const [totalPage, setTotalPage] = useState(0);
	const [selectedTitle, setSelectedTitle] = useState('');
	const [selectedYear, setSelectedYear] = useState('');

	const getList = async () => {
		try {
			let response = await axios.get(`${appUrl}/api/gallery`, {
				headers: {
					'Content-Type': 'application/json'
				},
				params: {
					'title': selectedTitle,
					'year': selectedYear,
				}
			})

			const { data, status } = response;

			if (data.success && status === 200) {
				setResults(data.results.data);
				setTotalPage(data.results.last_page);
			}
		} catch (error) {
			console.error(error.message);
		}
	}

	const loadMore = async () => {
		try {
			let response = await axios.get(`${appUrl}/api/gallery?page=${page + 1}`, {
				headers: {
					'Content-Type': 'application/json'
				},
				params: {
					'title': selectedTitle,
					'year': selectedYear,
				}
			})

			const { data, status } = response;

			if (data.success && status === 200) {
				setResults([...results, ...data.results.data]);
				setPage(page + 1);
			}
		} catch (error) {
			console.error(error.message);
		}
	}

	const handleFilter = () => {
		setPage(1);
		let filteredResults = results;

		if (selectedTitle) {
			filteredResults = filteredResults.filter(item => item.title === selectedTitle);
		}

		if (selectedYear) {
			filteredResults = filteredResults.filter(item => item.year === selectedYear);
		}

		setResults(filteredResults);
	}

	const resetFilter = () => {
		setSelectedTitle('');
		setSelectedYear('');
		setPage(1);
	}

	useEffect(() => {
		getList();
	}, [selectedTitle, selectedYear])

	console.log(selectedTitle === '' || selectedYear === '')

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

					{/* Filter Section */}
					<div className='bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-4 sm:p-6 mb-8 border border-gray-200 shadow-sm'>
						<h3 className="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
							<svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
							</svg>
							Filter
						</h3>
						<div className='grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4'>
							<div>
								<label htmlFor="title" className='block text-sm font-medium text-gray-700 mb-2'>
									Pekerjaan
								</label>
								<select
									id='title'
									onChange={e => setSelectedTitle(e.target.value)}
									className='w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all hover:border-gray-400'
								>
									<option value="">Semua Pekerjaan</option>
									{galleries?.map((item, index) => (
										<option key={index} value={item.title}>{item.title}</option>
									))}
								</select>
							</div>
							<div>
								<label htmlFor="year" className='block text-sm font-medium text-gray-700 mb-2'>
									Tahun
								</label>
								<select
									id='year'
									onChange={e => setSelectedYear(e.target.value)}
									className='w-full px-4 py-2 border border-gray-300 rounded-lg bg-white text-gray-900 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all hover:border-gray-400'
								>
									<option value="">Semua Tahun</option>
									{galleries?.map((item, index) => (
										<option key={index} value={item.year}>{item.year}</option>
									))}
								</select>
							</div>
						</div>
						<div>
							<Button onClick={resetFilter} disabled={selectedTitle === '' && selectedYear === ''}>Reset</Button>
						</div>
					</div>

					{/* Gallery Grid */}
					{results.length === 0 ? (
						<p className="text-center text-gray-400 p-4 bg-gray-200 rounded-xl">Belum ada dokumentasi yang ditambahkan.</p>
					) : (
						<WhenVisible data={[results]} fallback={() => (
							<div className='text-center'>
								<p>Loading...</p>
							</div>
						)}>
							<div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 space-y-4 animate-appear opacity-0 duration-300">
								{results.map((item, index) => (
									<a
										key={item.id}
										href={`/dokumentasi/${item.title}/${item.year}`}
										className="relative animate-appear cursor-pointer rounded-xl group overflow-hidden h-fit w-full"
									>
										<div
											style={{
												backgroundImage: `url('${item.image}')`
											}}
											className='aspect-square bg-cover bg-center rounded-xl group-hover:scale-105 transition-transform ease-in'
										/>

										{/* Hover Overlay dengan Judul */}
										{item.title && (
											<div className="absolute inset-0 rounded-xl bg-gradient-to-t from-black/70 via-black/50 to-transparent 
											flex flex-col justify-end p-4">
												<div className="translate-y-12 group-hover:translate-y-0 transition-transform duration-300">
													{item.year && (
														<span className="text-white/60 text-xs font-medium tracking-widest uppercase mb-1 block">
															{item.year}
														</span>
													)}
													<p className="text-white font-semibold text-sm leading-snug drop-shadow mb-4">
														{item.title}
													</p>
												</div>
												<Button className={'opacity-0 group-hover:opacity-100 transition-all backdrop-blur-md translate-y-10 group-hover:translate-y-0'}>
													Selengkapnya
												</Button>
											</div>
										)}
									</a>
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
			</div>
		</Section>
	);
};

export default Gallery;