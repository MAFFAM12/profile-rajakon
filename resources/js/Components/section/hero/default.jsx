import { Section } from "../../ui/section";
import { cn } from "../../../utils/cn";
import { Button } from "../../ui/button";
import { Mockup, MockupFrame } from "../../ui/mockup";
import { Autoplay, Pagination } from 'swiper/modules';
import { Swiper, SwiperSlide } from 'swiper/react';

import 'swiper/css';
import 'swiper/css/pagination';
import { benefits } from "../../../lib/data";

export default function Hero({ heroes, className }) {
	// Component untuk menampilkan multiple images dengan slide
	const ImageSlideCarousel = ({ images }) => (
		<Swiper
			spaceBetween={10}
			grabCursor={true}
			loop={true}
			autoplay={{
				delay: 3000,
				disableOnInteraction: false,
			}}
			modules={[Autoplay, Pagination]}
			pagination={{ clickable: true }}
			className="w-full h-full rounded-2xl"
		>
			{images.map((image, idx) => (
				<SwiperSlide key={idx}>
					<MockupFrame
						className="animate-appear opacity-0 delay-700"
						size="small"
					>
						<Mockup
							type="responsive"
							className="bg-background/90 w-full rounded-xl border-0"
						>
							<img src={image} alt={`Hero slide ${idx + 1}`} />
						</Mockup>
					</MockupFrame>
				</SwiperSlide>
			))}
		</Swiper>
	);

	// Component untuk menampilkan multiple images dengan card grid
	const ImageCardGrid = ({ images }) => (
		<div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 w-full pt-12">
			{images.map((image, idx) => (
				<div
					key={idx}
					className="animate-appear opacity-0 rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300"
					style={{ animationDelay: `${idx * 100}ms` }}
				>
					<MockupFrame
						className="h-full"
						size="small"
					>
						<Mockup
							type="responsive"
							className="bg-background/90 w-full rounded-xl border-0 h-64"
						>
							<img
								src={image}
								alt={`Hero card ${idx + 1}`}
								className="w-full h-full object-cover"
							/>
						</Mockup>
					</MockupFrame>
				</div>
			))}
		</div>
	);

	// Component untuk render images berdasarkan display type
	const renderImages = (item) => {
		if (!item.images || item.images.length === 0) {
			// Fallback ke hero_image jika tidak ada images array
			if (item.hero_image) {
				return (
					<div className="relative w-full pt-12">
						<MockupFrame
							className="animate-appear opacity-0 delay-700"
							size="small"
						>
							<Mockup
								type="responsive"
								className="bg-background/90 w-full rounded-xl border-0"
							>
								<img src={item.hero_image} alt={item.heading} />
							</Mockup>
						</MockupFrame>
					</div>
				);
			}
			return null;
		}

		const displayType = item.images_display_type || 'slide';

		return (
			<div className="relative w-full pt-12">
				{displayType === 'slide' ? (
					<ImageSlideCarousel images={item.images} />
				) : (
					<ImageCardGrid images={item.images} />
				)}
			</div>
		);
	};

	return (
		<Section
			className={cn(
				"overflow-hidden",
				className,
			)}
		>
			<div className="max-w-container mx-auto flex flex-col">
				<Swiper
					style={{
						'--swiper-navigation-color': '#fff',
						'--swiper-pagination-color': '#fff',
					}}
					spaceBetween={10}
					grabCursor={true}
					loop={false}
					autoplay={{
						delay: 5000,
						disableOnInteraction: false,
					}}
					modules={[Autoplay, Pagination]}
					className="w-full h-full rounded-2xl"
				>
					{
						heroes?.map((item, index) => (
							<SwiperSlide key={index}>
								<div className="flex flex-col items-center gap-6 text-center sm:gap-12">
									<h1 className="animate-appear from-foreground to-foreground dark:to-muted-foreground relative z-10 inline-block bg-linear-to-r bg-clip-text text-4xl leading-tight font-semibold text-balance text-transparent drop-shadow-2xl sm:text-6xl sm:leading-tight md:text-8xl md:leading-tight">
										{item.heading}
									</h1>
									<p className="text-md animate-appear text-muted-foreground relative z-10 font-medium text-balance opacity-0 delay-100 sm:text-xl">
										{item.sub_heading}
									</p>
									<div className="animate-appear relative z-10 flex justify-center gap-4 opacity-0 delay-300">
										<Button
											variant="default"
											size="lg"
											asChild
										>
											<a href={item.cta_link}>
												{item.cta_label}
											</a>
										</Button>
									</div>
									{renderImages(item)}
								</div>
							</SwiperSlide>
						))
					}
				</Swiper>

				<div className="grid md:grid-cols-3 gap-8 max-w-7xl mx-auto lg:p-0 mt-16">
					{benefits.map((benefit, index) => {
						const IconComponent = benefit.icon;
						return (
							<div key={index} className={`animate-appear delay-${index * 100} opacity-0 text-left group hover:transform hover:scale-105 transition-all duration-300 p-4 rounded-3xl bg-neutral-100`}>
								<div className="w-16 h-16 bg-linear-to-b from-primary/50 to-primary/100 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-primary/50">
									<IconComponent className="h-8 w-8 text-white" />
								</div>
								<h3 className="text-xl font-semibold text-gray-900 mb-3">
									{benefit.title}
								</h3>
								<p className="text-gray-600 leading-relaxed text-sm">
									{benefit.description}
								</p>
							</div>
						);
					})}
				</div>
			</div>
		</Section>
	);
}
