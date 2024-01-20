import styles from './ui.module.css'
import { MutableRefObject, useEffect, useRef, useState } from 'react';
import Console from '../components/console';
import { DBActions } from '../lib/db_actions';
import type { DBFieldType, DBTableType } from "../lib/db_types"
import DBTableComponent from '../components/table';
import { TabView, TabPanel } from 'primereact/tabview';


export default function Home() {
    const initialized: MutableRefObject<boolean> = useRef(false);
    const [fakeConsole, setFakeConsole] = useState(false);
    const [dataStructure, setDataStructure] = useState<{ [key: string]: any }>({});
    
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
            <h1 className='p-2 text-3xl text-center'>Liquidación de sueldos</h1>

            <h2 className='p-2 text-2xl text-center'>Carga de datos</h2>
            <TabView scrollable panelContainerClassName='p-5'>
            {Object.keys(dataStructure).map( (key) => (
                <TabPanel headerStyle={{background: 'none'}} headerClassName="border-dashed border-2 border-sky-500 *:p-2" key={key} header={key}>
                    <DBTableComponent jsonData={JSON.stringify(dataStructure[key])} name={key}></DBTableComponent>
                </TabPanel>
            ))}
            </TabView>
        </main>
    )
}
