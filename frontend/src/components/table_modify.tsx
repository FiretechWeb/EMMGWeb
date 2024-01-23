import type { DBFieldType, DBTableType } from "../lib/db_types"
import { useState, useEffect, useRef, MutableRefObject } from "react"
import { Button } from "primereact/button";
import { DBElementsList } from "./elements";
import FieldComponent from "./field";

interface TableModifyComponentProps {
    jsonTableData: string;
    name: string;
}

export default function TableModifyComponent(props: TableModifyComponentProps) {
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});
    const initialized: MutableRefObject<boolean> = useRef(false);
    const [rowSelected, setRowSelected] = useState<any>(null);
    //const [primaryKeys, setPrimaryKeys] = useState<Array<string>>([]);
    let fieldValues: any = {};

    const modifyElement = (event: any) => {
        if (!rowSelected) return;

        console.log("MODIFY", rowSelected);

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

    const elementSelected = (e: any) => {
        setRowSelected(e);
    }

    useEffect(() => {
        if (initialized.current) return;

        setFields(JSON.parse(props.jsonTableData)['fields']);

        initialized.current = true;
    }, [props]);

    return (
        <div>
            <h3 className="text-xl font-bold">Modificar {props.name}</h3>
        <form className="flex flex-col">
        <DBElementsList tableName={props.name} jsonTableData={props.jsonTableData} selectionChanged={elementSelected}></DBElementsList>
        {
        rowSelected &&
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