import styles from './index.module.css'
import { MutableRefObject, useEffect, useRef, useState } from 'react';
import Console from '../components/console';
import { DBActions } from '../lib/db_actions';
import type { DBFieldType, DBTableType } from "../lib/db_types"
import DBTableComponent from '../components/table';
import { TabView, TabPanel } from 'primereact/tabview';
import type { InferGetStaticPropsType, GetStaticProps } from 'next'

interface HomeProps {
    dataStructure: any
}

const getStructureAsProps = async () => {
    try {
        const r = await DBActions.getStructure();
        if (!r || !r.data) {
            return null;
        } else { //try again
            return { props: { dataStructure: r.data }};
        }
    } catch(e) {
        return null;
    }
}

export const getStaticProps = async (context: any) => {
    let staticProps: any = await getStructureAsProps();
    if (!staticProps) {
        staticProps = await getStructureAsProps(); //try again
        if (!staticProps) {
            staticProps = { props: { dataStructure: {} }};
        }
    }

    return staticProps;
};

export default function Home({dataStructure} : HomeProps) {
    const initialized: MutableRefObject<boolean> = useRef(false);
    const [fakeConsole, setFakeConsole] = useState(false);
    
    const handleKeyPress = (event: KeyboardEvent) => {
        if (event.key.toLowerCase() === 'f12') {
            setFakeConsole((prevValue) => !prevValue);
            event.preventDefault();
            return false;
        }
    };

    useEffect(() => {

        if (initialized.current) return;
        
        DBActions.setStructure(dataStructure);
        window.removeEventListener('keydown', handleKeyPress);
        window.addEventListener('keydown', handleKeyPress);
        
        initialized.current = true;

    }, [dataStructure]);

    return (
        <main className={styles.main}>
            {fakeConsole && <Console></Console>}
            <h1 className='p-2 text-3xl text-center'>Liquidación de sueldos</h1>

            <h2 className='p-2 text-2xl text-center'>Carga de datos</h2>
            <TabView scrollable panelContainerClassName='p-5'>
            {Object.keys(dataStructure).map( (key) => (
                <TabPanel headerStyle={{background: 'none'}} headerClassName="border-dashed border-2 border-sky-500 *:p-2" key={key} header={key}>
                    <DBTableComponent jsonTableData={JSON.stringify(dataStructure[key])} name={key}></DBTableComponent>
                </TabPanel>
            ))}
            </TabView>
        </main>
    )
}
