import { LinkedInLogoIcon, TwitterLogoIcon } from '@radix-ui/react-icons';
import { Building2, Facebook, Mail, MapPin, Phone } from 'lucide-react';
import React from 'react'

const Footer = ({ websiteSettings }) => {
    const currentYear = new Date().getFullYear();

    const quickLinks = [
        { name: 'Tentang', href: '#tentang' },
        { name: 'Layanan', href: '#layanan' },
        { name: 'Dokumentasi', href: '#dokumentasi' },
        { name: 'Blog', href: '#blog' },
        { name: 'Produk', href: '#produk' },
        { name: 'Klien', href: '#klien' },
        { name: 'Kontak', href: '#kontak' }
    ];

    return (
        <footer className="bg-gray-900 text-white">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    {/* Company Info */}
                    <div>
                        <div className="flex items-center space-x-3 mb-4">
                            <Building2 className="h-8 w-8 text-blue-400" />
                            <span className="text-xl font-bold">
                                {websiteSettings?.company_name || 'PT. Rajakon Teknik'}
                            </span>
                        </div>
                        <p className="text-gray-400 mb-6 leading-relaxed">
                            {websiteSettings?.company_description ||
                                'Mitra tepercaya Anda untuk solusi teknis komprehensif di seluruh Indonesia. Kami berkomitmen untuk memberikan keunggulan dalam setiap proyek.'}
                        </p>
                        <div className="flex space-x-4">
                            {websiteSettings?.social_media && Object.entries(websiteSettings.social_media).map(([platform, data]) => {
                                if (!data || !data.url) return null;

                                const getIcon = (platform) => {
                                    switch (platform.toLowerCase()) {
                                        case 'facebook':
                                            return <Facebook className="h-5 w-5" />;
                                        case 'linkedin':
                                            return <LinkedInLogoIcon className="h-5 w-5" />;
                                        case 'twitter':
                                            return <TwitterLogoIcon className="h-5 w-5" />;
                                        default:
                                            return <Building2 className="h-5 w-5" />;
                                    }
                                };

                                return (
                                    <a
                                        key={platform}
                                        href={data.url}
                                        target="_blank"
                                        rel="noopener noreferrer"
                                        className="text-gray-400 hover:text-blue-400 transition-colors duration-200"
                                        title={data.username || platform}
                                    >
                                        {getIcon(platform)}
                                    </a>
                                );
                            })}
                        </div>
                    </div>

                    {/* Quick Links */}
                    <div>
                        <h3 className="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul className="space-y-2">
                            {quickLinks.map((link) => (
                                <li key={link.name}>
                                    <a
                                        className="text-gray-400 hover:text-white transition-colors duration-200 text-sm"
                                    >
                                        {link.name}
                                    </a>
                                </li>
                            ))}
                        </ul>
                    </div>

                    {/* Contact Info */}
                    <div>
                        <h3 className="text-lg font-semibold mb-4">Informasi Kontak</h3>
                        <div className="space-y-3">
                            {websiteSettings?.phone && (
                                <div className="flex items-start space-x-3">
                                    <Phone className="h-5 w-5 text-blue-400 mt-0.5 flex-shrink-0" />
                                    <div className='text-gray-400 text-sm'>
                                        <p>{websiteSettings.phone}</p>
                                    </div>
                                </div>
                            )}
                            {websiteSettings?.email && (
                                <div className="flex items-start space-x-3">
                                    <Mail className="h-5 w-5 text-blue-400 mt-0.5 flex-shrink-0" />
                                    <div className='text-gray-400 text-sm'>
                                        <p>{websiteSettings.email}</p>
                                    </div>
                                </div>
                            )}
                            {websiteSettings?.address && (
                                <div className="flex items-start space-x-3">
                                    <MapPin className="h-5 w-5 text-blue-400 mt-0.5 flex-shrink-0" />
                                    <div className='text-gray-400 text-sm'>
                                        <p>{websiteSettings.address}</p>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>

                {/* Bottom Section */}
                <div className="border-t border-gray-800 mt-8 pt-8">
                    <div className="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <p className="text-gray-400 text-sm">
                            © {currentYear} {websiteSettings?.company_name || 'PT. Rajakon Teknik'}. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    )
}

export default Footer