import React from 'react'
import Layout from '../Layouts/Layout'
import { Head } from '@inertiajs/react'
import { cn } from '../utils/cn'
import { Section } from '../Components/ui/section'
import Footer from '../Components/section/footer/default'

const Tentang = (props) => {
    const { websiteSettings } = props;
    return (
        <Layout>
            <Head title="Rajakon - Tentang" />

            <main className="relative z-10">
                <Section>
                    <div className="relative flex h-fit w-full items-center justify-center bg-white dark:bg-black">
                        <div className="pointer-events-none absolute inset-0 flex items-center justify-center bg-white [mask-image:radial-gradient(ellipse_at_center,transparent_1%,black)] dark:bg-black"></div>
                        <div className='relative z-20'>
                            <div className="mx-auto w-full max-w-container space-y-6 text-base">
                                <img
                                    src="https://rajakon.com/public/dokumentasi/1644217100_WhatsApp%20Image%202021-12-09%20at%2012.09.45.jpeg"
                                    alt="Karyawan PT. Rajakon Teknik sedang melakukan thermovisi pada sebuah panel saat pelaksanaan assessment kelistrikan kantor cabang dan pusat Bank BJB seluruh indonesia"
                                    className='h-[650px] w-full object-cover object-bottom animate-appear rounded-3xl shadow-lg relative z-20'
                                />
                                <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4 animate-appear opacity-0 delay-100">Tentang Kami</h2>
                                <div className='animate-appear delay-200 opacity-0'>
                                    <p>
                                        PT. Rajakon Teknik bergerak dalam bidang pengadaan barang dan jasa dengan SDM berpengalaman, profesional, dan inovatif (bersertifikat tenaga ahli ESDM), berkomitmen untuk memberikan layanan berkualitas tinggi dengan fokus pada inovasi dan kepuasan pelanggan.
                                    </p>
                                    <p>
                                        PT. Rajakon Teknik melayani beberapa jasa berikut:
                                        <ol className='list-decimal ml-10 list-inside'>
                                            <li>Jasa Konsultan Kelistrikan</li>
                                            <li>Jasa Pembangunan dan Maintenance P2P, WAN, LAN, dan WLAN</li>
                                            <li>Jasa Perbaikan dan Pemeliharaan Perangkat Elektronik dan Perangkat Keras</li>
                                            <li>Jasa Perbaikan dan Pemeliharaan Sistem Monitoring</li>
                                            <li>Jasa Pemasangan dan Pemeliharaan Gardu Induk</li>
                                            <li>Jasa Perbaikan dan Pemeliharaan Infrastruktur Jaringan Data</li>
                                            <li>Jasa Perbaikan dan Pemeliharaan Kelistrikan</li>
                                            <li>Jasa Komisioning Tenaga Listrik</li>
                                            <li>Jasa Pembuatan Custom Modul Microcontroller</li>
                                            <li>Jasa Pembuatan Custom Modul Elektronik</li>
                                        </ol>
                                    </p>
                                    <br />
                                    <p>
                                        PT. Rajakon Teknik juga menawarkan beberapa produk, diantaranya adalah:
                                        <ol className='list-decimal ml-10 list-inside'>
                                            <li>Engine Motech Accelerator (EMA)</li>
                                            <li>SIMOJA (Sistem Monitoring Kerja Circuit Breaker)</li>
                                            <li>Scada HMI dan PLC BUD</li>
                                            <li>Sistem Monitoring Air Tanah dan Permukaan Berbasis Web dan GIS</li>
                                            <li>Sistem Thermography Online</li>
                                            <li>Software House</li>
                                            <li>Smart Farming</li>
                                            <li>Green Energy</li>
                                        </ol>
                                    </p>
                                </div>
                                <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4 animate-appear opacity-0 delay-100">Visi</h2>
                                <div className='animate-appear delay-300 opacity-0'>
                                    <p>
                                        Membangun Masa Depan Teknologi yang Berkelanjutan
                                        <ol className='list-decimal ml-10'>
                                            <li>Menjadi perusahaan Inovatif di bidang elektro, listrik, Scada, HMI, IoT, teknologi perangkat lunak dan teknologi terapan terdepan di Indonesia.</li>
                                            <li>Membangun ekosistem teknologi monitoring yang mendukung kemajuan masyarakat, industri dan pemerintahan.</li>
                                        </ol>
                                    </p>
                                </div>
                                <h2 className="text-3xl md:text-4xl font-bold text-gray-900 mb-4 animate-appear opacity-0 delay-100">Misi</h2>
                                <div className='animate-appear delay-400 opacity-0'>
                                    <p>
                                        <ol className='list-decimal ml-10'>
                                            <li>Mengembangkan teknologi elektro yang inovatif dan berkelanjutan untuk memenuhi kebutuhan masyarakat.</li>
                                            <li>Meningkatkan efisiensi dan kualitas produk melalui penelitian dan pengembangan.</li>
                                            <li>Membangun kerja sama strategis dengan mitra dan stakeholder untuk memperluas jangkauan dan kemampuan.</li>
                                        </ol>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </Section>
            </main >
            <Footer websiteSettings={websiteSettings} />
        </Layout >
    );
}

export default Tentang