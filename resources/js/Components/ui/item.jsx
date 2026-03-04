import * as React from "react";
import { cn } from "../../utils/cn";

function Item({
	className,
	...props
}) {
	return (
		<div
			data-slot="item"
			className={cn("text-foreground flex flex-row gap-4 relative z-20", className)}
			{...props} />
	);
}

function ItemContent({
	className,
	...props
}) {
	return (
		<div
			data-slot="item-content"
			className={cn(
				"flex flex-col gap-y-2",
				className
			)}
			{...props} />
	);
}

function ItemTitle({
	className,
	...props
}) {
	return (
		<h3
			data-slot="item-title"
			className={cn(
				"text-sm leading-none font-semibold tracking-tight sm:text-base",
				className
			)}
			{...props} />
	);
}

function ItemDescription({
	className,
	...props
}) {
	return (
		<div
			data-slot="item-description"
			className={cn(
				"text-muted-foreground flex max-w-[240px] flex-col gap-2 text-sm text-balance",
				className
			)}
			{...props} />
	);
}

function ItemIcon({
	className,
	...props
}) {
	return (
		<div
			data-slot="item-icon"
			className={cn("flex items-center self-start bg-linear-to-b from-primary/50 to-primary/100 p-4 h-full rounded-lg shadow-lg shadow-primary/50", className)}
			{...props} />
	);
}

export { Item, ItemContent, ItemDescription, ItemIcon, ItemTitle };
