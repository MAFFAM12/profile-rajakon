import React from 'react';
import { Section } from '../../ui/section';

const Clients = ({ partners = [] }) => {
	// Duplicate partners for seamless loop
	const displayPartners = [...partners, ...partners];

	return (
		<Section id="klien">
			<div className="max-w-container mx-auto flex flex-col items-center gap-6 sm:gap-20">
				<div className="max-w-7xl mx-auto w-full">
					{/* Section Header */}
					<div className="text-center mb-16">
						<h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4 animate-appear">
							Klien yang Memilih Kami
						</h2>
						<p className="text-lg text-gray-600 max-w-3xl mx-auto animate-appear opacity-0 delay-75">
							Bergabung dengan perusahaan-perusahaan terdepan yang mempercayakan visi mereka kepada kami
						</p>
					</div>

					{partners.length === 0 ? (
						<p className="text-center text-gray-400">Belum ada partner yang ditambahkan.</p>
					) : (
						<div className="logo-loop-container animate-appear opacity-0 duration-300">
							<div className="logo-loop-track">
								{displayPartners.map((partner, index) => (
									<div
										key={`${partner.id}-${index}`}
										className="logo-loop-item group relative flex items-center justify-center p-6 md:p-8 rounded-2xl bg-white border border-gray-100 hover:border-indigo-200 h-24 md:h-28 w-32 md:w-40"
									>
										<img
											src={partner.logo}
											alt={partner.name}
											className="h-14 md:h-20 w-auto object-contain grayscale group-hover:grayscale-0"
										/>
										<div className="absolute inset-0 rounded-2xl bg-gradient-to-r from-indigo-500/0 via-indigo-500/5 to-purple-500/0 opacity-0 group-hover:opacity-100 transition-opacity duration-500 pointer-events-none" />
									</div>
								))}
							</div>
						</div>
					)}
				</div>
			</div>
		</Section>
	);
};

export default Clients;