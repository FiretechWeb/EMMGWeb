import type { DBFieldType, DBTableType } from "../lib/db_types"
import { useState, useEffect } from "react"
import { Button } from "primereact/button";
import FieldComponent from "./field";
import { DBElementsList } from "./elements";

interface TableDeleteComponentProps {
    jsonTableData: string;
    name: string;
}

export default function TableDeleteComponent(props: TableDeleteComponentProps) {
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});
    const [rowSelected, setRowSelected] = useState<any>(null);


    const deleteElement = (event: any) => {
        if (!rowSelected) return;

        console.log("DELETE", rowSelected);

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

        <DBElementsList tableName={props.name} jsonTableData={props.jsonTableData} selectionChanged={elementSelected}></DBElementsList>

        {
            rowSelected && <Button onClick={deleteElement} className="bg-slate-500 p-1 m-1 self-center place-self-center" label="Eliminar"></Button>
        }
        </form>
        </div>
    )
}