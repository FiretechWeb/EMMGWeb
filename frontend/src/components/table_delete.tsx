import type { DBFieldType, DBTableType } from "../lib/db_types"
import { useState, useEffect } from "react"
import { Button } from "primereact/button";
import { DBElementsList } from "./elements";
import { DBActions } from "../lib/db_actions";

interface TableDeleteComponentProps {
    jsonTableData: string;
    name: string;
}

export default function TableDeleteComponent(props: TableDeleteComponentProps) {
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});
    const [rowSelected, setRowSelected] = useState<any>(null);
    const [forceListUpdate, setForceListUpdate] = useState(false);

    const requestForceListUpdate = () => {
        setForceListUpdate(true);
        requestAnimationFrame(() => {
            setForceListUpdate(false);
        });
    }

    const deleteElement = (event: any) => {
        if (!rowSelected) return;

        console.log("DELETE", rowSelected);
        const primaryKeys: Array<string> = DBActions.getPrimaryKeys(props.name);

        if (primaryKeys.length == 0) {
            console.error("primary keys not found in ", props.name);
            event.preventDefault();
            return;
        }

        if (primaryKeys.some( pkey => rowSelected[pkey] === null || rowSelected[pkey] === undefined)) {
            console.error("primary keys invalid", props.name);
            event.preventDefault();
            return;
        }

        let updateConditions: Array<any> = [];

        primaryKeys.forEach(pkey => {
            updateConditions.push({
                'field': pkey,
                'condition': "=",
                'result': rowSelected[pkey]
            });
        });

        DBActions.process(props.name, "delete", {
                'fields': {},
                'conditions': updateConditions
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
        setFields(JSON.parse(props.jsonTableData)['fields']);
    }, [props]);

    return (
        <div>
            <h3 className="text-xl font-bold">Eliminar {props.name}</h3>
        <form className="flex flex-col">

        {
           !forceListUpdate && <DBElementsList tableName={props.name} jsonTableData={props.jsonTableData} selectionChanged={elementSelected}></DBElementsList>
        }
        {
            rowSelected && <Button onClick={deleteElement} className="bg-slate-500 p-1 m-1 self-center place-self-center" label="Eliminar"></Button>
        }
        </form>
        </div>
    )
}