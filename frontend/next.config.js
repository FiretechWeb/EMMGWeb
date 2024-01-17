/**
 * @type {import('next').NextConfig}
 */
const nextConfig = {
    output: 'standalone',
     trailingSlash: true,
    //Básicamente este images : { unoptimized: true } fue el que me permitio generar los HTML
    
    images: {
        unoptimized: true,
        loader: 'akamai',
        path: '',
    },
  }
   
  module.exports = nextConfig