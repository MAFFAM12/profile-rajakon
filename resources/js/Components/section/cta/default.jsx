import { ArrowRight } from 'lucide-react';
import React from 'react'
import { Section } from '../../ui/section';

const CallToAction = () => {
    return (
        <div className="text-center mt-16">
            <div className="bg-blue-600 rounded-2xl p-8 md:p-12 text-white">
                <h3 className="text-2xl md:text-3xl font-bold mb-4">
                    Siap Memulai Proyek Anda?
                </h3>
                <p className="text-base text-blue-100 mb-8 max-w-2xl mx-auto">
                    Hubungi kami hari ini untuk mendiskusikan kebutuhan teknis Anda dan temukan
                    bagaimana kami dapat membantu mewujudkan proyek Anda.
                </p>
                <button
                    onClick={() => {
                        const element = document.getElementById('contact');
                        if (element) {
                            element.scrollIntoView({ behavior: 'smooth' });
                        }
                    }}
                    className="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors duration-200 shadow-lg"
                >
                    Konsultasi
                    <ArrowRight className="ml-2 h-5 w-5" />
                </button>
            </div>
        </div>
    )
}

export default CallToAction