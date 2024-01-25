import type { DBFieldType } from "../lib/db_types"
import { useState, useEffect, useRef, MutableRefObject } from "react"
import { Button } from "primereact/button";
import { DBElementsList } from "./elements";
import { DBActions } from "../lib/db_actions";
import FieldComponent from "./field";

interface TableModifyComponentProps {
    jsonTableData: string;
    tableName: string;
}

export default function TableModifyComponent(props: TableModifyComponentProps) {
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});
    const initialized: MutableRefObject<boolean> = useRef(false);
    const [rowSelected, setRowSelected] = useState<any>(null);
    const [forceFieldsUpdate, setForceFieldsUpdate] = useState(false);
    const [forceListUpdate, setForceListUpdate] = useState(false);
    const [displayName, setDisplayName] = useState<string>("");

    let fieldValues: any = {};

    const modifyElement = (event: any) => {
        if (!rowSelected) return;

        console.log("MODIFY", rowSelected);

        const primaryKeys: Array<string> = DBActions.getPrimaryKeys(props.tableName);

        if (primaryKeys.length == 0) {
            console.error("primary keys not found in ", props.tableName);
            event.preventDefault();
            return;
        }

        if (primaryKeys.some( pkey => rowSelected[pkey] === null || rowSelected[pkey] === undefined)) {
            console.error("primary keys invalid", props.tableName);
            event.preventDefault();
            return;
        }

        if (DBActions.isDataToSendValid(fieldValues, fields)) {
            let keysValues: any = {};

            primaryKeys.forEach(pkey => keysValues[pkey] = rowSelected[pkey]);

            DBActions.process(props.tableName, "update", {
                'fields': fieldValues,
                'conditions': [],
                'keys': keysValues
            }).then(r => {
                console.log(r);
                requestForceListUpdate();
            }).catch(e => console.error(e));

        } else {
            console.error("Missing fields or values to send data");
        }

        event.preventDefault();
    };

    const onFieldValueChanged = (fieldName: string, value: any) => {
        fieldValues[fieldName] = value;
    }
    const requestForceListUpdate = () => {
        setForceListUpdate(true);
        requestAnimationFrame(() => {
            setForceListUpdate(false);
        });
    }
    const requestFieldsRender = () => {
        setForceFieldsUpdate(true);
        requestAnimationFrame(() => {
            setForceFieldsUpdate(false);
        });
    }
    const elementSelected = (e: any) => {
        console.log(e);
        setRowSelected(e);
        requestFieldsRender();
    }

    useEffect(() => {
        if (initialized.current) return;

        const fieldsData: any = JSON.parse(props.jsonTableData);
        setFields(fieldsData['fields']);
        setDisplayName(fieldsData['display_name'] ?? props.tableName);
        
        initialized.current = true;
    }, [props]);

    return (
        <div>
            <h3 className="text-xl font-bold">Modificar {displayName}</h3>
        <form className="flex flex-col">
        {
        !forceListUpdate &&<DBElementsList tableName={props.tableName} jsonTableData={props.jsonTableData} selectionChanged={elementSelected}></DBElementsList>
        }

        {
        !forceFieldsUpdate && rowSelected &&
        Object.keys(fields)
            .filter(fieldName => fields[fieldName].allow_insert)
            .map( (fieldName) => (
                <FieldComponent key={fieldName} name={fieldName} onValueChanged={onFieldValueChanged} jsonFieldData={JSON.stringify(fields[fieldName])} value={rowSelected[fieldName]}></FieldComponent>
            ))
        }

        {
            rowSelected && <Button onClick={modifyElement} className="bg-slate-500 p-1 m-1 self-center place-self-center" label="Modificar"></Button>
        }
        </form>
        </div>
    )
}