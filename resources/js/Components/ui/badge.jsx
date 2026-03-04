import { cva } from "class-variance-authority";
import * as React from "react";
import { cn } from "../../utils/cn";

export const badgeVariants = cva(
	"inline-flex items-center rounded-full border border-border/100 dark:border-border/20 text-xs font-semibold transition-colors focus:outline-hidden focus:ring-2 focus:ring-ring focus:ring-offset-2 gap-2",
	{
		variants: {
			variant: {
				default:
					"border-transparent bg-primary text-primary-foreground dark:shadow-sm dark:border-transparent",
				brand:
					"border-transparent bg-brand text-primary-foreground dark:shadow-sm dark:border-transparent",
				secondary:
					"border-transparent bg-secondary text-secondary-foreground dark:shadow-sm dark:border-transparent",
				destructive:
					"border-transparent bg-destructive/30 text-destructive-foreground dark:shadow-sm dark:border-transparent",
				outline: "text-foreground",
			},
			size: {
				default: "px-2.5 py-1",
				sm: "px-1",
			},
		},
		defaultVariants: {
			variant: "default",
			size: "default",
		},
	},
);

export default function Badge({ className, variant, size, ...props }) {
	return (
		<div
			data-slot="badge"
			className={cn(badgeVariants({ variant, size }), className)}
			{...props}
		/>
	);
}
