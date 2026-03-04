import React, { useState } from 'react'
import { Section } from '../../ui/section'
import { Building2, Globe, Send } from 'lucide-react';
import { contactInfo } from '../../../lib/data';
import FormKontak from '../../FormKontak';


const Contact = () => {
    return (
        <Section id="kontak">
            <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div className="text-center mb-16">
                    <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4 animate-appear">
                        Hubungi kami
                    </h2>
                    <p className="text-base text-gray-600 max-w-3xl mx-auto animate-appear opacity-0 delay-75">
                        Siap mendiskusikan proyek Anda? Hubungi tim ahli kami
                        dan mari kita bahas bagaimana kami dapat membantu mewujudkan visi Anda.
                    </p>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <div className='flex flex-col justify-between animate-appear opacity-0 delay-300'>
                        <div className="space-y-6 mb-8">
                            {contactInfo.map((info, index) => {
                                const IconComponent = info.icon;
                                const colorClasses = {
                                    blue: 'bg-blue-100 text-blue-600',
                                    teal: 'bg-teal-100 text-teal-600',
                                    orange: 'bg-orange-100 text-orange-600',
                                    green: 'bg-green-100 text-green-600'
                                };

                                return (
                                    <div key={index} className="flex items-start space-x-4">
                                        <div className={`flex items-center justify-center p-4 rounded-lg ${colorClasses[info.color]}`}>
                                            <IconComponent className="h-6 w-6" />
                                        </div>
                                        <div>
                                            <h4 className="font-semibold text-gray-900 mb-1">{info.title}</h4>
                                            {info.details.map((detail, detailIndex) => (
                                                <p key={detailIndex} className="text-gray-600">{detail}</p>
                                            ))}
                                        </div>
                                    </div>
                                );
                            })}
                        </div>

                        {/* Company Info */}
                        <div className="bg-gray-50 rounded-lg p-6">
                            <div className="flex items-center space-x-3 mb-4">
                                <Building2 className="h-8 w-8 text-blue-600" />
                                <h4 className="text-xl font-semibold text-gray-900">PT. Rajakon Teknik</h4>
                            </div>
                            <p className="text-gray-600 mb-4">
                                Mitra tepercaya Anda untuk solusi teknis komprehensif di seluruh Indonesia. Kami berkomitmen untuk memberikan keunggulan dalam setiap proyek.
                            </p>
                            <div className="flex items-center space-x-2 text-gray-600">
                                <Globe className="h-4 w-4" />
                                <span>www.rajakon.com</span>
                            </div>
                        </div>
                    </div>

                    {/* Contact Form */}
                    <div className='animate-appear opacity-0 delay-700'>
                        <div className="glass-2 rounded-3xl shadow-lg p-8">
                            <h3 className="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h3>
                            <FormKontak />
                        </div>
                    </div>
                </div>
            </div>
        </Section>
    )
}

export default Contact