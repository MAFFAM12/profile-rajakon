import * as React from "react";
import { cn } from "../../utils/cn";

function Section({ className, ...props }) {
	return (
		<section
			data-slot="section"
			className={cn(
				"bg-background text-foreground px-4 pb-12 sm:pb-24 md:pb-32",
				className,
			)}
			{...props}
		/>
	);
}

export { Section };
