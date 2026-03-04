import React from 'react'
import ApplicationLogo from '../ApplicationLogo'
import ThemeSwitcher from '../Theme/ThemeSwitcher'
import { ActionMenu, Button } from '@primer/react-brand'
import { router } from '@inertiajs/react'

const Navbar = () => {
    const navs = [
        {
            label: "Informasi",
            href: "#",
            nested: [
                {
                    label: "Cara Kerja",
                    href: "#cara-kerja"
                },
                {
                    label: "Tutorial",
                    href: "#tutorial-pemasangan"
                },
                {
                    label: "Pemesanan",
                    href: "/pemesanan"
                },
            ]
        },
        { label: "Produk", href: "#produk", nested: [] },
        { label: "Testimoni", href: "#testimoni", nested: [] },
        { label: "Promo", href: "#promo", nested: [] },
        { label: "FAQ", href: "#faq", nested: [] },
    ]

    const [open, setOpen] = React.useState(false);

    return (
        <nav className='w-full fixed z-50 bg-white dark:bg-black md:bg-transparent md:dark:bg-transparent'>
            <div className='flex items-center justify-between gap-x-0 md:gap-x-6 py-[.5rem] px-4 md:px-8'>
                <ApplicationLogo width="w-20" />
                {/* Hamburger for mobile */}
                <button
                    className='md:hidden flex items-center border-2 min-h-8 px-3 rounded-lg border-[rgba(13,17,23,0.16078)] dark:border-[rgba(255,255,255,0.16078)] text-black dark:text-white'
                    onClick={() => setOpen(!open)}
                    aria-label="Toggle navigation"
                >
                    <svg className="fill-current h-5 w-5" viewBox="0 0 20 20"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
                </button>
                {/* Desktop nav */}
                <ul className='relative hidden md:flex gap-x-2 p-1 rounded-xl ring-1 backdrop-blur-lg ring-[rgba(13,17,23,0.16078)] dark:ring-[rgba(255,255,255,0.16078)]'>
                    {navs.map((item, i) => {
                        if (item?.nested.length > 1) {
                            return (
                                <li key={i}>
                                    <NestedNavButton
                                        block={true}
                                        label='Informasi'
                                        nested={item?.nested}
                                    />
                                </li>
                            )
                        } else {
                            return (
                                <li key={i}>
                                    <NavButton
                                        href={item?.href}
                                        label={item?.label}
                                    />
                                </li>
                            )
                        }
                    })}
                </ul>
                <div className='hidden md:block'>
                    <ThemeSwitcher />
                </div>
            </div>
            {/* Mobile nav */}
            <div className={`lg:hidden bg-white dark:bg-black transition-all duration-300 ${open ? 'max-h-96 py-2 opacity-100' : 'max-h-0 opacity-0 overflow-hidden'} shadow-md`}>
                <ul className='flex flex-col gap-y-1 px-4'>
                    {navs.map((item, i) => {
                        if (item?.nested.length > 1) {
                            return (
                                <li key={i}>
                                    <NestedNavButton
                                        block={true}
                                        label='Informasi'
                                        nested={item?.nested}
                                    />
                                </li>
                            )
                        } else {
                            return (
                                <li key={i}>
                                    <NavButton
                                        href={item?.href}
                                        label={item?.label}
                                        onClick={() => setOpen(false)}
                                        block={true}
                                    />
                                </li>
                            )
                        }
                    })}
                </ul>
                <div className='flex justify-center md:hidden mt-2 px-4'>
                    <ThemeSwitcher block={true} />
                </div>
            </div>
        </nav>
    )
}

export default Navbar

export const NavButton = ({ href = "#", label = "", block = false, type = "a", onClick = () => { } }) => {
    const [currentHash, setCurrentHash] = React.useState(window.location.hash);

    React.useEffect(() => {
        const onHashChange = () => setCurrentHash(window.location.hash);

        window.addEventListener('hashchange', onHashChange);
        return () => window.removeEventListener('hashchange', onHashChange);
    }, []);

    const isActive = (href) => currentHash === href || window.location.pathname === href;

    return (
        <Button
            as={type}
            size="small"
            variant={isActive(href) ? "accent" : ""}
            href={href}
            hasArrow={false}
            style={isActive(href) ? {
                backgroundColor: "#C00F0C",
                color: "white"
            } : {}
            }
            className={isActive(href) ? "" : "hover:bg-[#C00F0C]"}
            onClick={onClick}
            block={block}
        >
            {label}
        </Button>
    )
}

export const NestedNavButton = ({ label = "", block = false, nested = [] }) => {
    const [open, setOpen] = React.useState(false);

    return (
        <div className='transition-all duration-300'>
            <NavButton
                label={label}
                type='button'
                block={block}
                onClick={() => setOpen(!open)}
            />
            <ul className={`static md:absolute p-1 space-y-1 bg-white dark:bg-black rounded-xl ring-1 ring-[rgba(13,17,23,0.16078)] dark:ring-[rgba(255,255,255,0.16078)] ${open ? 'max-h-96 py-2 opacity-100 mt-4' : 'max-h-0 opacity-0 overflow-hidden'}`}>
                {nested.map((item, i) => (
                    <li key={i}>
                        <NavButton
                            href={item?.href}
                            label={item?.label}
                            block={true}
                            onClick={() => setOpen(false)}
                        />
                    </li>
                ))}
            </ul>
        </div>
    )
}