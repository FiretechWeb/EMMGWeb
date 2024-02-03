import { DataTable, DataTableSelectionSingleChangeEvent } from "primereact/datatable";
import { Column } from "primereact/column";
import { useState, useRef, MutableRefObject, useEffect } from "react";
import type { DBFieldType } from "../lib/db_types";
import { DBActions } from "../lib/db_actions";
import { useErrorState } from "../lib/global_store";

interface DBElementsListProps {
    tableName: string;
    jsonTableData: string;
    selectionChanged: Function;
}

export function DBElementsList(props: DBElementsListProps) {
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});
    const [elements, setElements] = useState<Array<any>>([]);
    const [displayElements, setDisplayElements] = useState<Array<any>>([]);
    const [selectedElement, setSelectedElement] = useState<any>(null);
    const initialized: MutableRefObject<boolean> = useRef(false);
    const setErrorState = useErrorState((state) => state.setError);

    const elementSelected = (event: DataTableSelectionSingleChangeEvent<any>) => {
        setSelectedElement(event.value);
        if (event.value && (event.value)['_uid']) {
            props.selectionChanged(elements.find(e => e['_uid'] && e['_uid'] == (event.value)['_uid']));
        } else {
            props.selectionChanged(event.value);
        }

    }

    useEffect(() => {
        if (initialized.current) return;

        setFields(JSON.parse(props.jsonTableData)['fields']);
        
        const primaryKeys: Array<string> = DBActions.getPrimaryKeys(props.tableName);
        DBActions.process(props.tableName, "get", DBActions.toParams(['related_data']))
        .then( r => {
            if (r && r.data) {
                setDisplayElements(r.data.map(
                    (fieldData: any) => {
                        let displayData: any = {};
                        Object.keys(fieldData).forEach( fieldName => {
                            displayData[fieldName] = DBActions.displayField(props.tableName, fieldName, fieldData);
                        });
                        return {_uid: DBActions.generateKeyFromField(fieldData, primaryKeys), ...displayData}
                    }
                ));

                setElements(r.data.map(
                    (fieldData: any) => {
                        return {_uid: DBActions.generateKeyFromField(fieldData, primaryKeys), ...fieldData}
                    }
                ));
            } else {
                setErrorState(`Invalid response type or data at DBElementsList: ${JSON.stringify(r, null, 2)}`);
                setElements([]);
            }
        }).catch(e => setErrorState(e));
        
        initialized.current = true;
    }, []);

    return (
        <DataTable className="m-3" value={displayElements} selectionMode="single" selection={selectedElement} onSelectionChange={elementSelected} dataKey="_uid" metaKeySelection={false} tableStyle={{ minWidth: '50rem' }}>
        {
            Object.keys(fields)
                .filter(fieldName => fields[fieldName].allow_insert)
                .map( (fieldName) => (
                    <Column className="m-2 p-2" headerClassName="m-2 p-2" key={fieldName} field={fieldName} header={fields[fieldName].display_name ?? fieldName}></Column>
                ))
        }
        </DataTable>
    )
}