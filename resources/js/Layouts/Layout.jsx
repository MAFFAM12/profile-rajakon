import { usePage } from '@inertiajs/react'
import { Toaster } from 'sonner'
import Navbar from '../Components/section/navbar/default';

const Layout = ({ children }) => {
    const { flash } = usePage().props;
    
    return (
        <div className='font-jakarta'>
            <Navbar
                mobileLinks={[
                    { text: "Tentang", href: "#tentang" },
                    { text: "Layanan", href: "#layanan" },
                    { text: "Partners", href: "#partners" },
                    { text: "Gallery", href: "#gallery" },
                    { text: "Kontak", href: "#kontak" },
                ]}
            />
            {children}
            <Toaster />
        </div>
    )
}

export default Layout