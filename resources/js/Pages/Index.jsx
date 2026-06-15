import React from 'react';
import { Head } from '@inertiajs/react';

import Layout from '../Layouts/Layout';
import AuroraBackground from '../Components/ui/aurora-background';
import Hero from '../Components/section/hero/default';
import About from '../Components/section/about/default';
import Items from '../Components/section/items/default';
import Service from '../Components/section/service/default';
import Clients from '../Components/section/clients/default';
import Gallery from '../Components/section/gallery/default';
import Produk from '../Components/section/produk/default';
import Contact from '../Components/section/contact/default';
import Footer from '../Components/section/footer/default';

const Index = (props) => {
  const { heroes, partners, galleries, produks, websiteSettings } = props;

  return (
    <Layout>
      <Head title="Rajakon - Profil Perusahaan" />

      <AuroraBackground>
        <Hero heroes={heroes} />
      </AuroraBackground>

      <main className="relative z-10">
        <About />
        <Items />
        <Clients partners={partners} />
        <Service />
        <Produk produks={produks} />
        <Gallery galleries={galleries} />
        <Contact />
      </main>

      <Footer websiteSettings={websiteSettings} />
    </Layout>
  );
};

export default Index;