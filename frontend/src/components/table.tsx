import type { DBFieldType, DBTableType } from "../lib/db_types"
import { useState, useEffect } from "react"
import { InputText } from 'primereact/inputtext';
import { InputNumber } from 'primereact/inputnumber';
import { Checkbox } from 'primereact/checkbox';
import { Calendar } from 'primereact/calendar';

function getComponentFromSQLType(componentKey: string, type: string, name: string) {
    if (type.toLowerCase().includes("varchar")) {
        return (
            <div key={componentKey}>
                <label>{name}</label>
                <InputText name={componentKey} ></InputText>
            </div>
        )
    } else if (type.toLowerCase().includes("bigint")) {
        return (
            <div key={componentKey}>
                <label>{name}</label>
                <InputNumber name={componentKey} ></InputNumber>
            </div>
        )
    } else if (type.toLowerCase().includes("int")) {
        return (
            <div key={componentKey}>
                <label>{name}</label>
                <InputNumber name={componentKey} ></InputNumber>
            </div>
        )
    } else if (type.toLowerCase().includes("tinyint")) {
        return (
            <div key={componentKey}>
                <label>{name}</label>
                <Checkbox checked={false}></Checkbox>
            </div>
        )
    } else if (type.toLowerCase().includes("date")) {
        return (
            <div key={componentKey}>
                <label>{name}</label>
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
    const [tableName, setTableName] = useState("");
    useEffect(() => {
        setFields(JSON.parse(props.jsonData)['fields']);
        setTableName(props.name)
    }, [props]);

    return(
        <div>
            <h2>{props.name}</h2>
            <form>
            {
            Object.keys(fields)
                .filter(fieldName => fields[fieldName].allow_insert)
                .map( (fieldName) => (
                    getComponentFromSQLType(fieldName, fields[fieldName].sql_type, fieldName)
                ))
            }
            </form>
            <hr />
        </div>
    )
}