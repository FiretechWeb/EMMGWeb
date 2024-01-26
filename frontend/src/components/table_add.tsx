import type { DBFieldType } from "../lib/db_types"
import { useState, useEffect, MutableRefObject, useRef } from "react"
import { Button } from "primereact/button";
import FieldComponent from "./field";
import { DBActions } from "../lib/db_actions";
import { useErrorState, useSuccessState, useUIActionState, UIActionStates } from "../lib/global_store";

interface TableAddComponentProps {
    jsonTableData: string;
    tableName: string;
}

export default function TableAddComponent(props: TableAddComponentProps) {
    
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});
    const initialized: MutableRefObject<boolean> = useRef(false);
    const [displayName, setDisplayName] = useState<string>("");
    const setErrorState = useErrorState((state) => state.setError);
    const setSuccessState = useSuccessState((state) => state.setSuccess);
    const setActionState = useUIActionState((state) => state.setUIActionState);

    let fieldValues: any = {};
    const addElement = (event: any) => {

        console.log(JSON.stringify(fieldValues));

        if (DBActions.isDataToSendValid(fieldValues, fields)) {
            DBActions.process(props.tableName, "insert", {
                'fields': fieldValues,
                'conditions': [],
                'keys': {}
            }).then(r => {
                if (!r.res) {
                    setErrorState("Invalid response type.");
                } else if (r.msg && r.res == 'error') {
                    setErrorState(r.msg)
                } else if (r.res == 'ok') {
                    setSuccessState("Data added correctly.");
                    setActionState(UIActionStates.NONE);
                } else {
                    setErrorState("Invalid response type.");
                }
                
            }).catch(e => setErrorState(e));
        } else {
            setErrorState("Missing fields or values to send data");
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