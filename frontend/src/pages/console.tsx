import styles from './console.module.css'
import Console from '../components/console'

export default function Home() {
  return (
    <main className={styles.main}>
      <Console></Console>
    </main>
  )
}
