import type { DBFieldType, DBTableType } from "../lib/db_types"
import { useState, useEffect, MutableRefObject, useRef } from "react"
import { Button } from "primereact/button";
import FieldComponent from "./field";

interface TableAddComponentProps {
    jsonTableData: string;
    name: string;
}

export default function TableAddComponent(props: TableAddComponentProps) {
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});
    const initialized: MutableRefObject<boolean> = useRef(false);

    const addElement = (event: any) => {
        //add element here!
        event.preventDefault();
    };

    useEffect(() => {
        if (initialized.current) return;

        setFields(JSON.parse(props.jsonTableData)['fields']);

        initialized.current = true;
    }, [props]);

    return (
        <div>
            <h3 className="text-xl font-bold">Agregar {props.name}</h3>
        <form className="flex flex-col">
        {
        Object.keys(fields)
            .filter(fieldName => fields[fieldName].allow_insert)
            .map( (fieldName) => (
                <FieldComponent key={fieldName} name={fieldName} jsonFieldData={JSON.stringify(fields[fieldName])}></FieldComponent>
            ))
        }
        <Button onClick={addElement} className="bg-slate-500 p-1 m-1 self-center place-self-center" label="Agregar"></Button>
        </form>
        </div>
    )
}