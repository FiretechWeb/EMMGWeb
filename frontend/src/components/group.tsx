import DBTableComponent from '../components/table';
import { TabView, TabPanel } from 'primereact/tabview';

interface GroupData {
    group?: string;
    display_name?: string;
    [key: string]: any; // Allow other properties
}

interface TableGroupProps {
    tableGroup: GroupData
}
interface GroupsData {
    [key: string]: GroupData;
}

const renderTabs = (data: GroupsData) => {

return (
    <TabView scrollable panelContainerClassName='p-5'> 
    {
        Object.entries(data).map(([groupName, groupData]) => (
            <TabPanel headerStyle={{background: 'none'}} headerClassName="border-dashed border-2 border-sky-500 *:p-2" key={groupName} header={groupData.display_name ? groupData.display_name : groupName}>
                {groupData.fields && <DBTableComponent jsonTableData={JSON.stringify(groupData)} tableName={groupName}></DBTableComponent>}
                {groupData && typeof groupData === 'object' && !groupData.fields && renderTabs(groupData)}
            </TabPanel>
        ))
    }
    </TabView>
    );
};

export default function TableGroup({tableGroup} : TableGroupProps) {

    return (
        <>
        {renderTabs(tableGroup)}
        </>
    )
}
