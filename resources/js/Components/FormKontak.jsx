import React, { useState } from 'react'
import { Button } from './ui/button';
import { Send } from 'lucide-react';
import { useForm } from '@inertiajs/react';
import { checkForError } from '../utils/checkForError';
import { toast } from 'sonner'
import Input from './ui/input';

const FormKontak = () => {
    const [validationStatus, setValidationStatus] = useState({
        nama: '',
        email: '',
        perusahaan: '',
        telepon: '',
        layanan_minat: '',
        pesan: ''
    });

    const { data, setData, post, processing, errors, setError } = useForm({
        nama: '',
        email: '',
        perusahaan: '',
        telepon: '',
        layanan_minat: '',
        pesan: ''
    });

    const submit = (e) => {
        e.preventDefault();

        post('/contact-message', {
            preserveScroll: true,
            preserveState: true,
            forceFormData: true,
            onSuccess: page => {
                if (page?.props?.flash?.success == null) {
                    setError({
                        nama: checkForError(page?.props?.flash, setValidationStatus, 'nama'),
                        email: checkForError(page?.props?.flash, setValidationStatus, 'email'),
                        perusahaan: checkForError(page?.props?.flash, setValidationStatus, 'perusahaan'),
                        telepon: checkForError(page?.props?.flash, setValidationStatus, 'telepon'),
                        layanan_minat: checkForError(page?.props?.flash, setValidationStatus, 'layanan_minat'),
                        pesan: checkForError(page?.props?.flash, setValidationStatus, 'pesan'),
                    })
                } else {
                    toast.success('Terima kasih! Pesan Anda telah berhasil dikirim.', {
                        duration: 2000,
                        description: page?.props?.flash?.success,
                    });
                }
            }
        })
    };

    return (
        <form onSubmit={submit} className="space-y-6">
            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <Input
                    key={'nama'}
                    label='Nama Lengkap *'
                    errorMessage={errors.nama}
                    onChange={e => setData('nama', e.target.value)}
                    required
                />
                <Input
                    key={'email'}
                    label='Alamat Email *'
                    errorMessage={errors.email}
                    onChange={e => setData('email', e.target.value)}
                    required
                />
            </div>

            <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <Input
                    key={'perusahaan'}
                    label='Perusahaan'
                    errorMessage={errors.perusahaan}
                    onChange={e => setData('perusahaan', e.target.value)}
                    required
                />
                <Input
                    key={'telepon'}
                    type='tel'
                    label='Nomor telepon'
                    errorMessage={errors.telepon}
                    onChange={e => setData('telepon', e.target.value)}
                    required
                />
            </div>

            <div>
                <label htmlFor="layanan_minat" className="block text-sm font-medium text-gray-700 mb-2">
                    Layanan Minat
                </label>
                <select
                    id="layanan_minat"
                    name="layanan_minat"
                    onChange={e => setData('layanan_minat', e.target.value)}
                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                    <option value="">Pilih layanan</option>
                    <option value="construction">Jasa Konstruksi</option>
                    <option value="mechanical">Teknik Mesin</option>
                    <option value="electrical">Sistem Kelistrikan</option>
                    <option value="safety">Keselamatan & Kepatuhan</option>
                    <option value="maintenance">Layanan Pemeliharaan</option>
                    <option value="logistics">Logistik & Dukungan</option>
                    <option value="other">Lainnya</option>
                </select>
                <span>{errors.layanan_minat}</span>
            </div>

            <div>
                <label htmlFor="pesan" className="block text-sm font-medium text-gray-700 mb-2">
                    Pesan *
                </label>
                <textarea
                    id="pesan"
                    name="pesan"
                    rows={5}
                    required
                    onChange={e => setData('pesan', e.target.value)}
                    className="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-vertical"
                    placeholder="Ceritakan kepada kami tentang kebutuhan pada proyek Anda..."
                ></textarea>
            </div>

            <Button
                type="submit"
                className={'w-full py-6'}
                disabled={processing}
            >
                Kirim Pesan
                <Send className="ml-2 h-5 w-5" />
            </Button>
        </form>
    )
}

export default FormKontak