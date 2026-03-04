"use client";

import { cn } from "../../utils/cn";

export default function Screenshot({
	src,
	alt,
	width,
	height,
	className,
}) {
	if (!src) {
		return (
			<div
				style={{ width, height }}
				className={cn("bg-muted", className)}
				aria-label={alt}
			/>
		);
	}

	return (
		<img
			src={src}
			alt={alt}
			width={width}
			height={height}
			className={className}
		/>
	);
}
