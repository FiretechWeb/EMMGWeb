import styles from './ui.module.css'
import { processCMD, addCMD, cmdType } from '../lib/cmds';
import { createDBcmds } from '../lib/db_cmds';
import { MutableRefObject, useEffect, useRef, useState } from 'react';
import Console from '../components/console';

export default function Home() {
    const initialized: MutableRefObject<boolean> = useRef(false);
    const [fakeConsole, setFakeConsole] = useState(false);

    const handleKeyPress = (event: KeyboardEvent) => {
        if (event.key === 'f') {
            setFakeConsole((prevValue) => !prevValue);
            event.preventDefault();
            return false;
        }
      };

    useEffect(() => {
        window.addEventListener('keydown', handleKeyPress);
        return () => {
          window.removeEventListener('keydown', handleKeyPress);
        };
    }, []);
    
    return (
        <main>
            {fakeConsole && <Console></Console>}
        </main>
    )
}
