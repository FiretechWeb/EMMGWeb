import type { DBFieldType } from "../lib/db_types"
import { useState, useEffect, MutableRefObject, useRef } from "react"
import { Button } from "primereact/button";
import FieldComponent from "./field";
import { DBActions } from "../lib/db_actions";

interface TableAddComponentProps {
    jsonTableData: string;
    tableName: string;
}

export default function TableAddComponent(props: TableAddComponentProps) {
    
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});
    const initialized: MutableRefObject<boolean> = useRef(false);
    const [displayName, setDisplayName] = useState<string>("");

    let fieldValues: any = {};
    const addElement = (event: any) => {

        console.log(JSON.stringify(fieldValues));

        if (DBActions.isDataToSendValid(fieldValues, fields)) {
            DBActions.process(props.tableName, "insert", {
                'fields': fieldValues,
                'conditions': [],
                'keys': {}
            }).then(r => {
                console.log(r);
            }).catch(e => console.error(e));
        } else {
            console.error("Missing fields or values to send data");
        }

        event.preventDefault();
    };

    const onFieldValueChanged = (fieldName: string, value: any) => {
        fieldValues[fieldName] = value;
    }

    useEffect(() => {
        if (initialized.current) return;
        
        const fieldsData: any = JSON.parse(props.jsonTableData);
        setFields(fieldsData['fields']);
        setDisplayName(fieldsData['display_name'] ?? props.tableName);

        initialized.current = true;
    }, [props, fieldValues]);

    return (
        <div>
            <h3 className="text-xl font-bold">Agregar {displayName}</h3>
        <form className="flex flex-col" autoComplete="off">
        {
        Object.keys(fields)
            .filter(fieldName => fields[fieldName].allow_insert)
            .map( (fieldName) => (
                <FieldComponent key={fieldName} name={fieldName} onValueChanged={onFieldValueChanged} jsonFieldData={JSON.stringify(fields[fieldName])}></FieldComponent>
            ))
        }
        <Button onClick={addElement} className="bg-slate-500 p-1 m-1 self-center place-self-center" label="Agregar"></Button>
        </form>
        </div>
    )
}