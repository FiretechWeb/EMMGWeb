import type { DBFieldType } from "../lib/db_types"
import { useState, useEffect, useRef, MutableRefObject } from "react"
import { Button } from "primereact/button";
import { DBElementsList } from "./elements";
import { DBActions } from "../lib/db_actions";
import FieldComponent from "./field";
import { useErrorState, useSuccessState, useCurrentTableState, usePreviousTableState } from "../lib/global_store";

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
    const setErrorState = useErrorState((state) => state.setError);
    const setSuccessState = useSuccessState((state) => state.setSuccess);
    const setTableFieldsData = useCurrentTableState((state) => state.setData);
    const setPrevTableFieldsData = usePreviousTableState((state) => state.setData);
    const tableFieldsData = useCurrentTableState((state) => state.data);
    const fieldsData: MutableRefObject<any> = useRef({});

    const modifyElement = (event: any) => {
        if (!rowSelected) return;

        console.log("MODIFY", rowSelected);

        const primaryKeys: Array<string> = DBActions.getPrimaryKeys(props.tableName);

        if (primaryKeys.length == 0) {
            setErrorState(`primary keys not found in ${props.tableName}`);
            event.preventDefault();
            return;
        }

        if (primaryKeys.some( pkey => rowSelected[pkey] === null || rowSelected[pkey] === undefined)) {
            setErrorState(`primary keys invalid ${props.tableName}`);
            event.preventDefault();
            return;
        }

        if (DBActions.isDataToSendValid(fieldsData.current, fields)) {
            let keysValues: any = {};

            primaryKeys.forEach(pkey => keysValues[pkey] = rowSelected[pkey]);

            DBActions.process(props.tableName, "update", {
                'fields': fieldsData.current,
                'conditions': [],
                'keys': keysValues
            }).then(r => {
                if (!r.res) {
                    setErrorState("Invalid response type.");
                } else if (r.msg && r.res == 'error') {
                    setErrorState(r.msg)
                } else if (r.res == 'ok') {
                    requestForceListUpdate();
                    setSuccessState("Data modified correctly.");
                } else {
                    setErrorState("Invalid response type.");
                }
            }).catch(e => setErrorState(e));
        } else {
            setErrorState("Missing fields or values to modify data");
        }

        event.preventDefault();
    };

    const onFieldValueChanged = (fieldName: string, value: any) => {
        fieldsData.current[fieldName] = value;
        setPrevTableFieldsData({...tableFieldsData});
        setTableFieldsData({...fieldsData.current});
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
        setPrevTableFieldsData({...tableFieldsData});
        setTableFieldsData({...rowSelected});
    }, [rowSelected]);

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
        <form className="flex flex-col" autoComplete="off">
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