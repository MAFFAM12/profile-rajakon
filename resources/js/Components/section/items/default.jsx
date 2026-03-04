import {
	CheckCircle,
} from "lucide-react";

import { Item, ItemContent, ItemDescription, ItemIcon, ItemTitle } from "../../ui/item";
import { Section } from "../../ui/section";
import { mainBenefits } from "../../../lib/data";
import { useState } from "react";
import CardHoverEffect from "../../ui/card-hover-effect";

export default function Items({ title = "Mengapa Memilih Kami ?", className }) {

	let [hoveredIndex, setHoveredIndex] = useState(null);

	return (
		<Section className={className}>
			<div
				className="max-w-container mx-auto flex flex-col items-center gap-6 sm:gap-20">
				<h2
					className="max-w-[570px] text-center text-3xl leading-tight font-semibold sm:text-5xl sm:leading-tight animate-appear">
					{title}
				</h2>
				{mainBenefits !== false && mainBenefits.length > 0 && (
					<div
						className="grid grid-cols-1 gap-y-10 gap-x-4 md:grid-cols-2 lg:grid-cols-3 animate-appear opacity-0 delay-300">

						{mainBenefits.map((item, index) => (
							<div
								key={index}
								className="relative group block p-4 h-full w-full"
								onMouseEnter={() => setHoveredIndex(index)}
								onMouseLeave={() => setHoveredIndex(null)}
							>
								<CardHoverEffect hoveredIndex={hoveredIndex} index={index} />
								<Item>
									<ItemIcon>
										<CheckCircle className="size-8 stroke-2 stroke-white" />
									</ItemIcon>
									<ItemContent>
										<ItemTitle className="flex items-center gap-2">
											{item.title}
										</ItemTitle>
										<ItemDescription>{item.description}</ItemDescription>
									</ItemContent>
								</Item>
							</div>
						))}
					</div>
				)}
			</div>
		</Section>
	);
}
