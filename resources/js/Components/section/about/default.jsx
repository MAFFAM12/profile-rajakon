import React, { useState } from 'react'
import { Section } from '../../ui/section'
import { cn } from '../../../utils/cn'
import { Eye, Play, Target } from 'lucide-react'
import CardHoverEffect from '../../ui/card-hover-effect'
import { Button } from '../../ui/button'

function About({ className }) {

    let [hoveredIndex, setHoveredIndex] = useState(null);

    return (
        <Section
            className={cn(
                "overflow-hidden",
                className,
            )}
            id="tentang"
        >
            <div className="relative flex h-fit w-full items-center justify-center bg-white dark:bg-black">
                <div
                    className={cn(
                        "absolute inset-0",
                        "[background-size:10px_10px]",
                        "[background-image:radial-gradient(blue_.5px,white_1px)]",
                    )}
                />
                {/* Radial gradient for the container to give a faded look */}
                <div className="pointer-events-none absolute inset-0 flex items-center justify-center bg-white [mask-image:radial-gradient(ellipse_at_center,transparent_1%,black)] dark:bg-black"></div>
                <div className='relative z-20'>
                    <div className="mx-auto w-full max-w-container">
                        <div>
                            <h3 className="text-4xl font-bold text-gray-900 mb-6">Tentang Kami</h3>
                            <div className='grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6'>
                                <div className='space-y-6'>
                                    <div
                                        className="relative group block p-4"
                                        onMouseEnter={() => setHoveredIndex(0)}
                                        onMouseLeave={() => setHoveredIndex(null)}
                                    >
                                        <CardHoverEffect hoveredIndex={hoveredIndex} index={0} />
                                        <div className='animate-appear space-y-6 text-gray-600 text-sm md:text-base p-8 glass-2 shadow-lg rounded-3xl relative z-20'>
                                            <p>
                                                PT. Rajakon Teknik didirikan dengan visi untuk mentransformasi lanskap layanan teknis
                                                di Indonesia. Dengan pengalaman bertahun-tahun dan komitmen
                                                terhadap keunggulan, kami telah menjadi mitra tepercaya bagi berbagai bisnis di berbagai industri.
                                            </p>
                                            <p>
                                                Perusahaan kami berspesialisasi dalam menyediakan solusi teknis komprehensif
                                                yang memenuhi kebutuhan infrastruktur modern dan pengembangan industri
                                                yang terus berkembang. Kami menggabungkan keahlian tradisional dengan teknologi mutakhir
                                                untuk memberikan hasil yang melampaui harapan.
                                            </p>
                                            <p>
                                                Kini, kami terus memperluas kapabilitas dan memperkuat posisi
                                                kami sebagai pemimpin dalam layanan teknis, dengan senantiasa mempertahankan nilai-nilai inti
                                                kami, yaitu kualitas, integritas, dan kepuasan pelanggan.
                                            </p>
                                            <Button asChild>
                                                <a href="https://youtu.be/5gHpzE596gc?si=p52sO8XC7Q5hx_ig" target='_blank'>
                                                    Tonton Video
                                                    <Play className='size-4 ml-2' />
                                                </a>
                                            </Button>
                                        </div>
                                    </div>

                                    <div
                                        className="relative group block p-4"
                                        onMouseEnter={() => setHoveredIndex(1)}
                                        onMouseLeave={() => setHoveredIndex(null)}
                                    >
                                        <CardHoverEffect hoveredIndex={hoveredIndex} index={1} />
                                        <div className="animate-appear delay-100 bg-blue-50 p-6 rounded-3xl shadow-lg relative z-20">
                                            <div className="flex items-center mb-4">
                                                <Target className="h-8 w-8 text-blue-600 mr-3" />
                                                <h4 className="text-xl font-semibold text-gray-900">Misi Kami</h4>
                                            </div>
                                            <p className="text-gray-700">
                                                Untuk menyediakan layanan teknis yang luar biasa dan solusi inovatif yang mendorong kesuksesan bagi klien kami sekaligus berkontribusi terhadap pembangunan infrastruktur Indonesia.
                                            </p>
                                        </div>
                                    </div>

                                    <div
                                        className="relative group block p-4"
                                        onMouseEnter={() => setHoveredIndex(2)}
                                        onMouseLeave={() => setHoveredIndex(null)}
                                    >
                                        <CardHoverEffect hoveredIndex={hoveredIndex} index={2} />
                                        <div className="animate-appear delay-300 bg-sky-50 p-6 rounded-3xl shadow-lg relative z-20">
                                            <div className="flex items-center mb-4">
                                                <Eye className="h-8 w-8 text-sky-600 mr-3" />
                                                <h4 className="text-xl font-semibold text-gray-900">Visi Kami</h4>
                                            </div>
                                            <p className="text-gray-700">
                                                Menjadi perusahaan jasa teknis paling tepercaya dan inovatif di Indonesia, yang menetapkan standar industri untuk kualitas dan keunggulan.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div
                                    className="relative group block p-4"
                                    onMouseEnter={() => setHoveredIndex(3)}
                                    onMouseLeave={() => setHoveredIndex(null)}
                                >
                                    <CardHoverEffect hoveredIndex={hoveredIndex} index={3} />
                                    <img
                                        src="https://rajakon.com/public/dokumentasi/1644304207_IMG_20211025_101910877.jpg"
                                        alt="Karyawan PT. Rajakon Teknik sedang melakukan thermovisi pada sebuah panel saat pelaksanaan assessment kelistrikan kantor cabang dan pusat Bank BJB seluruh indonesia"
                                        className='h-full w-full animate-appear opacity-0 delay-700 rounded-3xl shadow-lg relative z-20'
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </Section >
    )
}

export default About