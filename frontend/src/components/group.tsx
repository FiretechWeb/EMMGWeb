import DBTableComponent from '../components/table';
import { TabView, TabPanel } from 'primereact/tabview';

interface TableGroupProps {
    tableGroup: any
}

export default function TableGroup({tableGroup} : TableGroupProps) {
    
    return (
        <>
        {Object.keys(tableGroup).length > 1 && (<TabView scrollable panelContainerClassName='p-5'>
            {Object.keys(tableGroup).map( (key) => (
                <TabPanel headerStyle={{background: 'none'}} headerClassName="border-dashed border-2 border-sky-500 *:p-2" key={key} header={tableGroup[key]['display_name'] ?? key}>
                    <DBTableComponent jsonTableData={JSON.stringify(tableGroup[key])} tableName={key}></DBTableComponent>
                </TabPanel>
            ))}
        </TabView>)
        }
        {Object.keys(tableGroup).length == 1 && Object.keys(tableGroup).map( (key) => (
            <DBTableComponent jsonTableData={JSON.stringify(tableGroup[key])} tableName={key}></DBTableComponent>
        ))}
        </>
    )
}
