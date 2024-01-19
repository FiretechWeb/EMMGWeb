import styles from './ui.module.css'
import { MutableRefObject, useEffect, useRef, useState } from 'react';
import Console from '../components/console';
import { DBActions } from '../lib/db_actions';

export default function Home() {
    const initialized: MutableRefObject<boolean> = useRef(false);
    const [fakeConsole, setFakeConsole] = useState(false);
    const [dataStructure, setDataStructure] = useState({});
    
    const handleKeyPress = (event: KeyboardEvent) => {
        if (event.key.toLowerCase() === 'f12') {
            setFakeConsole((prevValue) => !prevValue);
            event.preventDefault();
            return false;
        }
    };

    useEffect(() => {

        if (initialized.current) return;

        window.addEventListener('keydown', handleKeyPress);

        DBActions.getStructure().then( r => {
            if (!r || !r.data) return;

            setDataStructure(r.data);

        }).catch( e => console.error(e) );

        initialized.current = true;

        return () => {
          window.removeEventListener('keydown', handleKeyPress);
        };

    }, []);

    return (
        <main>
            {fakeConsole && <Console></Console>}
            {Object.keys(dataStructure).map( (key) => (
                <div key={key}>Table: {key}</div>
            ))}
        </main>
    )
}
