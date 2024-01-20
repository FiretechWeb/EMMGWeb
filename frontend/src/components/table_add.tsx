import type { DBFieldType, DBTableType } from "../lib/db_types"
import { useState, useEffect } from "react"
import { Button } from "primereact/button";
import FieldComponent from "./field";

interface TableAddComponentProps {
    jsonTableData: string;
    name: string;
}

export default function TableAddComponent(props: TableAddComponentProps) {
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});
    const agregarElemento = (event: any) => {
        //add element here!
        event.preventDefault();
      };

    useEffect(() => {
        setFields(JSON.parse(props.jsonTableData)['fields']);
    }, [props]);

    return (
        <form className="flex flex-col">
        {
        Object.keys(fields)
            .filter(fieldName => fields[fieldName].allow_insert)
            .map( (fieldName) => (
                <FieldComponent name={fieldName} jsonFieldData={JSON.stringify(fields[fieldName])}></FieldComponent>
            ))
        }
        <Button onClick={agregarElemento} className="bg-slate-500 p-1 m-1 self-center place-self-center" label="Agregar"></Button>
        </form>
    )
}