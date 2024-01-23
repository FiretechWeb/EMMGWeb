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
    let fieldValues: any = {};
    const addElement = (event: any) => {
        //let rowToAdd = {};
        console.log(JSON.stringify(fieldValues));

        const emptyFields: boolean = Object.keys(fields)
            .filter(fieldName => fields[fieldName].allow_insert)
            .some(fieldName => {
                if (fieldValues[fieldName] === null || fieldValues[fieldName] === undefined)
                    return true;
                if (typeof fieldValues[fieldName] === "string" && (fieldValues[fieldName] as string).trim().length <= 0) {
                    return true;
                }
                return false;
            });

        if (emptyFields) {
            console.log("THERE ARE STILL SOME EMPTY FIELDS");
        }

        event.preventDefault();
    };

    const onFieldValueChanged = (fieldName: string, value: any) => {
        fieldValues[fieldName] = value;
    }

    useEffect(() => {
        if (initialized.current) return;
        
        setFields(JSON.parse(props.jsonTableData)['fields']);

        initialized.current = true;
    }, [props, fieldValues]);

    return (
        <div>
            <h3 className="text-xl font-bold">Agregar {props.name}</h3>
        <form className="flex flex-col">
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