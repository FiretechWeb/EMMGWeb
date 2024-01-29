import type { DBFieldType } from "../lib/db_types"
import { useState, useEffect, MutableRefObject, useRef } from "react"
import { Button } from "primereact/button";
import FieldComponent from "./field";
import { DBActions } from "../lib/db_actions";
import { useErrorState, useSuccessState, useUIActionState, UIActionStates, useCurrentTableState, usePreviousTableState } from "../lib/global_store";

interface TableAddComponentProps {
    jsonTableData: string;
    tableName: string;
}

export default function TableAddComponent(props: TableAddComponentProps) {
    
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});
    const initialized: MutableRefObject<boolean> = useRef(false);
    const fieldsData: MutableRefObject<any> = useRef({});

    const [displayName, setDisplayName] = useState<string>("");
    const setErrorState = useErrorState((state) => state.setError);
    const setSuccessState = useSuccessState((state) => state.setSuccess);
    const setActionState = useUIActionState((state) => state.setUIActionState);
    const setTableFieldsData = useCurrentTableState((state) => state.setData);
    const setPrevTableFieldsData = usePreviousTableState((state) => state.setData);
    const tableFieldsData = useCurrentTableState((state) => state.data);

    const addElement = (event: any) => {

        if (DBActions.isDataToSendValid(fieldsData.current, fields)) {
            DBActions.process(props.tableName, "insert", {
                'fields': fieldsData.current,
                'conditions': [],
                'keys': {}
            }).then(r => {
                if (!r.res) {
                    setErrorState(`FATAL ERROR: ${r}`);
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
        fieldsData.current[fieldName] = value;
        setPrevTableFieldsData({...tableFieldsData});
        setTableFieldsData({...fieldsData.current});
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