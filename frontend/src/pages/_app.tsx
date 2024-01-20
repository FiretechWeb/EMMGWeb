import '../app/globals.css'
import { PrimeReactProvider } from 'primereact/api';
import "primereact/resources/themes/bootstrap4-dark-purple/theme.css";


import type { AppProps } from 'next/app'
 
export default function MyApp({ Component, pageProps }: AppProps) {
  return (
  <PrimeReactProvider>
    <Component {...pageProps} />
  </PrimeReactProvider>)
}