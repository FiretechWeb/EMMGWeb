import styles from './index.module.css'
import { MutableRefObject, useEffect, useRef, useState } from 'react';
import Console from '../components/console';
import { DBActions } from '../lib/db_actions';
import { TabView, TabPanel } from 'primereact/tabview';
import TableGroup from '../components/group';
import { useErrorState, useSuccessState } from '../lib/global_store';
import { Dialog } from 'primereact/dialog';

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
    const [tableGroups, setTableGroups] = useState<any>({});
    const currentError = useErrorState((state) => state.error);
    const currentSuccess = useSuccessState((state) => state.success);
    const cleanError = useErrorState((state) => state.cleanError);
    const cleanSuccess = useSuccessState((state) => state.cleanSuccess);

    const handleKeyPress = (event: KeyboardEvent) => {
        if (!event || !event.key) return false;
        
        if (event.key.toLowerCase() === 'f12') {
            setFakeConsole((prevValue) => !prevValue);
            event.preventDefault();
            return false;
        }
    };

    useEffect(() => {

        if (initialized.current) return;
        
        DBActions.setStructure(dataStructure);
        setTableGroups(DBActions.getTableGroups());
        
        window.removeEventListener('keydown', handleKeyPress);
        window.addEventListener('keydown', handleKeyPress);
        
        initialized.current = true;

    }, [dataStructure]);

    return (
        <main className={styles.main}>
            {fakeConsole && <Console></Console>}

            <Dialog header="Error" visible={typeof currentError === 'string' && currentError.length > 0} contentClassName='p-2' headerClassName='p-2 text-red-600 text-3xl' style={{ width: '50vw'}} onHide={() => cleanError()}>
                <p className="m-0 text-red-600 text-2xl text-center">
                    {currentError}
                </p>
            </Dialog>

            <Dialog header="Success" visible={typeof currentSuccess === 'string' && currentSuccess.length > 0} contentClassName='p-2' headerClassName='p-2 text-green-600 text-3xl' style={{ width: '50vw'}} onHide={() => cleanSuccess()}>
                <p className="m-0 text-green-600 text-2xl text-center">
                    {currentSuccess}
                </p>
            </Dialog>

            <h1 className='p-2 text-3xl text-center'>Liquidación de sueldos</h1>

            <h2 className='p-2 text-2xl text-center'>Carga de datos</h2>
            <TabView scrollable panelContainerClassName='p-5'>
            {
            Object.keys(tableGroups).map( (groupName) => (
                <TabPanel headerStyle={{background: 'none'}} headerClassName="border-dashed border-2 border-sky-500 *:p-2" key={groupName} header={groupName}>
                    <TableGroup tableGroup={tableGroups[groupName]}></TableGroup>
                </TabPanel>
            ))}
            </TabView>
        </main>
    )
}
