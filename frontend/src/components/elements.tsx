import { DataTable } from "primereact/datatable";
import { Column } from "primereact/column";
import { useState, useRef, MutableRefObject, useEffect } from "react";
import type { DBFieldType } from "../lib/db_types";
import { DBActions } from "../lib/db_actions";

interface DBElementsListProps {
    tableName: string;
    jsonTableData: string;
    selectionChanged: Function;
}

export function DBElementsList(props: DBElementsListProps) {
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});
    const [elements, setElements] = useState<Array<any>>([]);
    const [selectedElement, setSelectedElement] = useState<any>(null);
    const initialized: MutableRefObject<boolean> = useRef(false);

    useEffect(() => {
        if (initialized.current) return;

        setFields(JSON.parse(props.jsonTableData)['fields']);
        
        const primaryKeys: Array<string> = DBActions.getPrimaryKeys(props.tableName);
        DBActions.process(props.tableName, "get", DBActions.toParams([]))
        .then( r => {
            if (r && r.data) {
                setElements(r.data.map(
                    (fieldData: any) => {
                        return {_uid: DBActions.generateKeyFromField(fieldData, primaryKeys), ...fieldData}
                    }
                ));
            } else {
                setElements([]);
            }
        }).catch(e => console.error(e));
        
        initialized.current = true;
    }, []);

    return (
        <DataTable className="m-3" value={elements} selectionMode="single" selection={selectedElement} onSelectionChange={(e) => { setSelectedElement(e.value); props.selectionChanged(e.value)}} dataKey="_uid" metaKeySelection={false} tableStyle={{ minWidth: '50rem' }}>
        {
            Object.keys(fields)
                .filter(fieldName => fields[fieldName].allow_insert)
                .map( (fieldName) => (
                    <Column className="m-2 p-2" headerClassName="m-2 p-2" key={fieldName} field={fieldName} header={fieldName}></Column>
                ))
        }
        </DataTable>
    )
}