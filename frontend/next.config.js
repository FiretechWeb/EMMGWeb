/**
 * @type {import('next').NextConfig}
 */
const nextConfig = {
    reactStrictMode: true,
    output: 'standalone',
     trailingSlash: true,

     experimental: {
        images: {
          unoptimized: true,
        },
      },
      /*
    images: {
        //unoptimized: true,
        loader: 'akamai',
        path: '',
    },*/
    distDir: '.next',
  }
   
  module.exports = nextConfig