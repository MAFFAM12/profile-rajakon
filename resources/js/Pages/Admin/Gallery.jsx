import React, { useState } from 'react';
import { router, usePage } from '@inertiajs/react';

const AdminGallery = () => {
  const { galleries, flash } = usePage().props; // flash untuk notif success

  const [formData, setFormData] = useState({
    image: null,
    title: '',
    order: '',
  });

  const handleChange = (e) => {
    if (e.target.name === 'image') {
      setFormData({ ...formData, image: e.target.files[0] });
    } else {
      setFormData({ ...formData, [e.target.name]: e.target.value });
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    const data = new FormData();
    data.append('image', formData.image);
    data.append('title', formData.title);
    data.append('order', formData.order);

    router.post('/admin/gallery', data, {
      onSuccess: () => {
        setFormData({ image: null, title: '', order: '' });
      },
    });
  };

  const handleDelete = (id) => {
    if (confirm('Yakin hapus gambar ini?')) {
      router.delete(`/admin/gallery/${id}`);
    }
  };

  return (
    <div className="min-h-screen bg-gray-100 p-8">
      <div className="max-w-5xl mx-auto">
        <h1 className="text-3xl font-bold mb-8">Kelola Dokumentasi Proyek</h1>

        {/* Notif success */}
        {flash?.success && (
          <div className="mb-6 p-4 bg-green-100 text-green-800 rounded-lg">
            {flash.success}
          </div>
        )}

        {/* Form Upload */}
        <div className="bg-white p-6 rounded-lg shadow mb-10">
          <h2 className="text-xl font-semibold mb-4">Upload Gambar Baru</h2>
          <form onSubmit={handleSubmit}>
            <div className="mb-4">
              <label className="block text-sm font-medium mb-2">Gambar</label>
              <input
                type="file"
                name="image"
                accept="image/*"
                onChange={handleChange}
                className="w-full p-2 border rounded"
                required
              />
            </div>

            <div className="mb-4">
              <label className="block text-sm font-medium mb-2">Judul (opsional)</label>
              <input
                type="text"
                name="title"
                value={formData.title}
                onChange={handleChange}
                className="w-full p-2 border rounded"
              />
            </div>

            <div className="mb-4">
              <label className="block text-sm font-medium mb-2">Urutan (opsional)</label>
              <input
                type="number"
                name="order"
                value={formData.order}
                onChange={handleChange}
                className="w-full p-2 border rounded"
                min="0"
              />
            </div>

            <button
              type="submit"
              className="bg-blue-600 text-white px-6 py-3 rounded hover:bg-blue-700"
            >
              Upload Gambar
            </button>
          </form>
        </div>

        {/* Daftar Gambar */}
        <div className="bg-white p-6 rounded-lg shadow">
          <h2 className="text-xl font-semibold mb-4">Daftar Gambar</h2>
          {galleries.length > 0 ? (
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
              {galleries.map((item) => (
                <div key={item.id} className="border rounded-lg overflow-hidden">
                  <img
                    src={item.image}
                    alt={item.title || 'Gambar dokumentasi'}
                    className="w-full h-48 object-cover"
                  />
                  <div className="p-4">
                    {item.title && <p className="font-medium">{item.title}</p>}
                    <p className="text-sm text-gray-500">Urutan: {item.order}</p>
                    <button
                      onClick={() => handleDelete(item.id)}
                      className="mt-2 text-red-600 hover:text-red-800 text-sm"
                    >
                      Hapus
                    </button>
                  </div>
                </div>
              ))}
            </div>
          ) : (
            <p className="text-gray-500 text-center">Belum ada gambar.</p>
          )}
        </div>
      </div>
    </div>
  );
};

export default AdminGallery;