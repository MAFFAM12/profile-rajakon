import { usePage } from '@inertiajs/react'
import { Toaster } from 'sonner'
import Navbar from '../Components/section/navbar/default';

const Layout = ({ children }) => {
    return (
        <div className='font-jakarta'>
            <Navbar
                mobileLinks={[
                    { text: "Tentang", href: "/#tentang" },
                    { text: "Layanan", href: "/#layanan" },
                    { text: "Klien", href: "/#klien" },
                    { text: "Produk", href: "/#produk" },
                    { text: "Blog", href: "/blog" },
                    { text: "Dokumentasi", href: "/#dokumentasi" },
                    { text: "Kontak", href: "/#kontak" },
                ]}
            />
            {children}
            <Toaster />
        </div>
    )
}

export default Layout