import type { DBFieldType } from "../lib/db_types"
import { useState, useEffect, MutableRefObject, useRef } from "react"
import { Button } from "primereact/button";
import { DBElementsList } from "./elements";
import { DBActions } from "../lib/db_actions";

interface TableDeleteComponentProps {
    jsonTableData: string;
    tableName: string;
}

export default function TableDeleteComponent(props: TableDeleteComponentProps) {
    const initialized: MutableRefObject<boolean> = useRef(false);
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});
    const [rowSelected, setRowSelected] = useState<any>(null);
    const [forceListUpdate, setForceListUpdate] = useState(false);
    const [displayName, setDisplayName] = useState<string>("");

    const requestForceListUpdate = () => {
        setForceListUpdate(true);
        requestAnimationFrame(() => {
            setForceListUpdate(false);
        });
    }

    const deleteElement = (event: any) => {
        if (!rowSelected) return;

        console.log("DELETE", rowSelected);
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

        let keysValues: any = {};

        primaryKeys.forEach(pkey => keysValues[pkey] = rowSelected[pkey]);

        DBActions.process(props.tableName, "delete", {
                'fields': {},
                'conditions': [],
                'keys': keysValues
        }).then(r => {
            console.log(r);
            requestForceListUpdate();
        }).catch(e => console.error(e));

        event.preventDefault();
    };
    
    const elementSelected = (e: any) => {
        setRowSelected(e);
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
            <h3 className="text-xl font-bold">Eliminar {displayName}</h3>
        <form className="flex flex-col" autoComplete="off">

        {
           !forceListUpdate && <DBElementsList tableName={props.tableName} jsonTableData={props.jsonTableData} selectionChanged={elementSelected}></DBElementsList>
        }
        {
            rowSelected && <Button onClick={deleteElement} className="bg-slate-500 p-1 m-1 self-center place-self-center" label="Eliminar"></Button>
        }
        </form>
        </div>
    )
}