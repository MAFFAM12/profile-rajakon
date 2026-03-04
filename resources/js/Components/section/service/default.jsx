import React from 'react'
import { Section } from '../../ui/section'
import { services } from '../../../lib/data'
import { ArrowRight } from 'lucide-react'

const Service = () => {
    return (
        <Section id="layanan">
            <div
                className="max-w-container mx-auto flex flex-col items-center gap-6 sm:gap-20">
                <div className="max-w-7xl mx-auto">
                    {/* Section Header */}
                    <div className="text-center mb-16">
                        <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4 animate-appear">
                            Layanan Kami
                        </h2>
                        <p className="text-lg text-gray-600 max-w-3xl mx-auto animate-appear opacity-0 delay-75">
                            Kami menawarkan berbagai layanan teknis komprehensif yang dirancang untuk memenuhi
                            beragam kebutuhan bisnis modern dan proyek infrastruktur.
                        </p>
                    </div>

                    {/* Services Grid */}
                    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 animate-appear opacity-0 duration-300">
                        {services.map((service, index) => {
                            const IconComponent = service.icon;
                            return (
                                <div
                                    key={index}
                                    className="bg-neutral-100 rounded-3xl transition-all hover:transform hover:scale-105 duration-300 p-6 group"
                                >
                                    <div className="flex items-center justify-center w-16 h-16 bg-linear-to-b from-primary/50 to-primary/100 p-4 rounded-lg shadow-lg shadow-primary/50 mb-6 transition-colors duration-300">
                                        <IconComponent className="h-8 w-8 text-white" />
                                    </div>

                                    <h3 className="text-xl font-semibold text-gray-900 mb-3">
                                        {service.title}
                                    </h3>

                                    <p className="text-gray-600 mb-4">
                                        {service.description}
                                    </p>

                                    <ul className="space-y-2 mb-6">
                                        {service.features.map((feature, featureIndex) => (
                                            <li key={featureIndex} className="flex items-center text-sm text-gray-600">
                                                <div className="w-1.5 h-1.5 bg-blue-600 rounded-full mr-2"></div>
                                                {feature}
                                            </li>
                                        ))}
                                    </ul>
                                </div>
                            );
                        })}
                    </div>

                    {/* Call to Action */}
                    <div className="text-center mt-16 animate-appear opacity-0 delay-500">
                        <div className="bg-linear-to-b from-primary/50 to-primary/100 h-full transition-shadow duration-300 hover:shadow-lg shadow-primary/50 rounded-3xl p-8 md:p-12 text-white">
                            <h3 className="text-2xl md:text-3xl font-bold mb-4">
                                Siap Memulai Proyek Anda?
                            </h3>
                            <p className="text-base text-blue-100 mb-8 max-w-2xl mx-auto">
                                Hubungi kami hari ini untuk mendiskusikan persyaratan teknis Anda dan temukan bagaimana kami dapat membantu mewujudkan proyek Anda menuju kesuksesan.
                            </p>
                            <button
                                onClick={() => {
                                    const element = document.getElementById('kontak');
                                    if (element) {
                                        element.scrollIntoView({ behavior: 'smooth' });
                                    }
                                }}
                                className="inline-flex items-center px-8 py-4 bg-white text-brand font-semibold rounded-xl hover:bg-gray-200 transition-colors duration-200 cursor-pointer"
                            >
                                Konsultasi
                                <ArrowRight className="ml-2 h-5 w-5" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Section>
    )
}

export default Service