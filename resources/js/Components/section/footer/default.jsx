import { LinkedInLogoIcon, TwitterLogoIcon } from '@radix-ui/react-icons';
import { Building2, Facebook, Mail, MapPin, Phone } from 'lucide-react';
import React from 'react'
import { contactInfo, services } from '../../../lib/data';

const Footer = () => {
    const currentYear = new Date().getFullYear();

    const quickLinks = [
        { name: 'Home', href: 'hero' },
        { name: 'About Us', href: 'about' },
        { name: 'Services', href: 'services' },
        { name: 'Contact', href: 'contact' }
    ];

    return (
        <footer className="bg-gray-900 text-white">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    {/* Company Info */}
                    <div className="lg:col-span-1">
                        <div className="flex items-center space-x-3 mb-4">
                            <Building2 className="h-8 w-8 text-blue-400" />
                            <span className="text-xl font-bold">PT. Rajakon Teknik</span>
                        </div>
                        <p className="text-gray-400 mb-6 leading-relaxed">
                            Mitra tepercaya Anda untuk solusi teknis komprehensif di seluruh Indonesia. Kami berkomitmen untuk memberikan keunggulan dalam setiap proyek.
                        </p>
                        <div className="flex space-x-4">
                            <a href="#" className="text-gray-400 hover:text-blue-400 transition-colors duration-200">
                                <LinkedInLogoIcon className="h-5 w-5" />
                            </a>
                            <a href="#" className="text-gray-400 hover:text-blue-400 transition-colors duration-200">
                                <TwitterLogoIcon className="h-5 w-5" />
                            </a>
                            <a href="#" className="text-gray-400 hover:text-blue-400 transition-colors duration-200">
                                <Facebook className="h-5 w-5" />
                            </a>
                        </div>
                    </div>

                    {/* Quick Links */}
                    <div>
                        <h3 className="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul className="space-y-2">
                            {quickLinks.map((link) => (
                                <li key={link.name}>
                                    <button
                                        onClick={() => scrollToSection(link.href)}
                                        className="text-gray-400 hover:text-white transition-colors duration-200"
                                    >
                                        {link.name}
                                    </button>
                                </li>
                            ))}
                        </ul>
                    </div>

                    {/* Services */}
                    <div>
                        <h3 className="text-lg font-semibold mb-4">Layanan Kami</h3>
                        <ul className="space-y-2">
                            {services.map((service, index) => (
                                <li key={index}>
                                    <span className="text-gray-400 text-sm">{service.title}</span>
                                </li>
                            ))}
                        </ul>
                    </div>

                    {/* Contact Info */}
                    <div>
                        <h3 className="text-lg font-semibold mb-4">Informasi Kontak</h3>
                        <div className="space-y-3">
                            {contactInfo.map((info, index) => {
                                const IconComponent = info.icon;
                                const colorClasses = {
                                    blue: 'bg-blue-100 text-blue-600',
                                    teal: 'bg-teal-100 text-teal-600',
                                    orange: 'bg-orange-100 text-orange-600',
                                    green: 'bg-green-100 text-green-600'
                                };

                                return (
                                    <div key={index} className="flex items-start space-x-3">
                                        <IconComponent className="h-5 w-5 text-blue-400 mt-0.5 flex-shrink-0" />
                                        <div className='text-gray-400 text-sm'>
                                            {info.details.map((detail, detailIndex) => (
                                                <p key={detailIndex}>{detail}</p>
                                            ))}
                                        </div>
                                    </div>
                                );
                            })}
                        </div>
                    </div>
                </div>

                {/* Bottom Section */}
                <div className="border-t border-gray-800 mt-8 pt-8">
                    <div className="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <p className="text-gray-400 text-sm">
                            © {currentYear} PT. Rajakon Teknik. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    )
}

export default Footer