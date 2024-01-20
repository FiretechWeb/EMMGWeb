import type { DBFieldType, DBTableType } from "../lib/db_types"
import { useState, useEffect } from "react"
import { InputText } from 'primereact/inputtext';
import { InputNumber } from 'primereact/inputnumber';
import { Checkbox } from 'primereact/checkbox';
import { Calendar } from 'primereact/calendar';
import { Button } from "primereact/button";

function getComponentFromSQLType(componentKey: string, type: string, name: string) {
    if (type.toLowerCase().includes("varchar")) {
        return (
            <div className="m-2" key={componentKey}>
                <label className="mx-2">{name}: </label>
                <InputText name={componentKey} ></InputText>
            </div>
        )
    } else if (type.toLowerCase().includes("bigint")) {
        return (
            <div className="m-2" key={componentKey}>
                <label className="mx-2">{name}: </label>
                <InputNumber name={componentKey} ></InputNumber>
            </div>
        )
    } else if (type.toLowerCase().includes("int")) {
        return (
            <div className="m-2" key={componentKey}>
                <label className="mx-2">{name}: </label>
                <InputNumber name={componentKey} ></InputNumber>
            </div>
        )
    } else if (type.toLowerCase().includes("tinyint")) {
        return (
            <div className="m-2" key={componentKey}>
                <label className="mx-2">{name}: </label>
                <Checkbox checked={false}></Checkbox>
            </div>
        )
    } else if (type.toLowerCase().includes("date")) {
        return (
            <div className="m-2" key={componentKey}>
                <label className="mx-2">{name}: </label>
                <Calendar></Calendar>
            </div>
        )
    }

    return <div key={componentKey}></div>;
}

interface TableComponentProps {
    jsonData: string;
    name: string;
}

export default function DBTableComponent(props: TableComponentProps) {
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});

    const agregarElemento = (event: any) => {
        //add element here!
        event.preventDefault();
      };

    useEffect(() => {
        setFields(JSON.parse(props.jsonData)['fields']);
    }, [props]);

    return(
        <div>
            <h2 className="text-xl font-bold">{props.name}</h2>
            <form className="flex flex-col"> 
            {
            Object.keys(fields)
                .filter(fieldName => fields[fieldName].allow_insert)
                .map( (fieldName) => (
                    getComponentFromSQLType(fieldName, fields[fieldName].sql_type, fieldName)
                ))
            }

            <Button onClick={agregarElemento} className="bg-slate-500 p-1 m-1 self-center place-self-center" label="Agregar"></Button>
            </form>
            <hr />
        </div>
    )
}