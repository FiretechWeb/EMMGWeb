/**
 * @type {import('next').NextConfig}
 */
const nextConfig = {
    output: 'standalone',
     trailingSlash: true,
    
    images: {
        unoptimized: true,
        loader: 'akamai',
        path: '',
    },
  }
   
  module.exports = nextConfig