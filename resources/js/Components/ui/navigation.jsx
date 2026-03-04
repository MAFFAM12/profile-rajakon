"use client";
import { Link } from "@inertiajs/react";
import { cn } from "../../utils/cn";

import {
	NavigationMenu,
	NavigationMenuContent,
	NavigationMenuItem,
	NavigationMenuLink,
	NavigationMenuList,
	NavigationMenuTrigger,
	navigationMenuTriggerStyle,
} from "./navigation-menu";
import Rajakon from "../logos/rajakon";

export default function Navigation({
	menuItems = [
		{
			title: "Tentang",
			isLink: true,
			href: "#tentang",
		},
		{
			title: "Layanan",
			isLink: true,
			href: "#layanan",
		},
		{
			title: "Kontak",
			isLink: true,
			href: "#kontak",
		},
	],
	components = [
		{
			title: "EMA",
			href: "https://motechstore.id",
			description:
				"Produk penurun emisi bahan bakar",
		},
		{
			title: "Assesment Kelistrikan",
			href: "https://motechstore.id",
			description:
				"Jasa pemeliharan sistem kelistrikan",
		},
		{
			title: "Early Warning System",
			href: "https://motechstore.id",
			description:
				"Produk dan jasa pengamanan dan pemeliharaan sistem kelistrikan",
		},
	],
	logo = <Rajakon width="w-16" />,
	logoTitle = "PT. Rajakon Teknik",
	logoDescription = "Perusahaan kami memiliki kompetensi untuk menyediakan solusi teknis dan komprehensif.",
	logoHref = "https://www.launchuicomponents.com/",
	introItems = [
		{
			title: "Introduksi",
			href: "https://www.launchuicomponents.com/",
			description:
				"Perusahaan teknis yang menyediakan solusi inovatif.",
		},
		{
			title: "Visi dan Misi",
			href: "https://www.launchuicomponents.com/",
			description: "Menjadi perusahaan jasa teknik yang paling terpercaya",
		},
		{
			title: "Mengapa Kami",
			href: "https://www.launchuicomponents.com/",
			description: "Mengapa memilih produk barang dan jasa kami",
		},
	],
}) {
	return (
		<NavigationMenu className="hidden md:flex">
			<NavigationMenuList>
				{menuItems.map((item, index) => (
					<NavigationMenuItem key={index}>
						{item.isLink ? (
							<NavigationMenuLink
								className={navigationMenuTriggerStyle()}
								asChild
							>
								<Link href={item.href || ""}>{item.title}</Link>
							</NavigationMenuLink>
						) : (
							<>
								<NavigationMenuTrigger>{item.title}</NavigationMenuTrigger>
								<NavigationMenuContent>
									{item.content === "default" ? (
										<ul className="grid gap-3 p-4 md:w-[400px] lg:w-[500px] lg:grid-cols-[.75fr_1fr]">
											<li className="row-span-3">
												<NavigationMenuLink asChild>
													<a
														className="from-muted/30 to-muted/10 flex h-full w-full flex-col justify-end rounded-md bg-linear-to-b p-6 no-underline outline-hidden select-none focus:shadow-md"
														href={logoHref}
													>
														{logo}
														<div className="mt-4 mb-2 text-lg font-medium">
															{logoTitle}
														</div>
														<p className="text-muted-foreground text-sm leading-tight">
															{logoDescription}
														</p>
													</a>
												</NavigationMenuLink>
											</li>
											{introItems.map((intro, i) => (
												<ListItem key={i} href={intro.href} title={intro.title}>
													{intro.description}
												</ListItem>
											))}
										</ul>
									) : item.content === "components" ? (
										<ul className="grid w-[400px] gap-3 p-4 md:w-[500px] md:grid-cols-2 lg:w-[600px]">
											{components.map((component) => (
												<ListItem
													key={component.title}
													title={component.title}
													href={component.href}
												>
													{component.description}
												</ListItem>
											))}
										</ul>
									) : (
										item.content
									)}
								</NavigationMenuContent>
							</>
						)}
					</NavigationMenuItem>
				))}
			</NavigationMenuList>
		</NavigationMenu>
	);
}

function ListItem({
	className,
	title,
	children,
	...props
}) {
	return (
		<li>
			<NavigationMenuLink asChild>
				<a
					data-slot="list-item"
					className={cn(
						"hover:bg-accent hover:text-accent-foreground focus:bg-accent focus:text-accent-foreground block space-y-1 rounded-md p-3 leading-none no-underline outline-hidden transition-colors select-none",
						className,
					)}
					{...props}
				>
					<div className="text-sm leading-none font-medium">{title}</div>
					<p className="text-muted-foreground line-clamp-2 text-sm leading-snug">
						{children}
					</p>
				</a>
			</NavigationMenuLink>
		</li>
	);
}
