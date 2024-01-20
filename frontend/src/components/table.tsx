import type { DBFieldType, DBTableType } from "../lib/db_types"
import { useState, useEffect } from "react"

function getComponentFromSQLType(componentKey: string, type: string, name: string, children = null) {
    if (type.toLowerCase().includes("varchar")) {
        return (
            <div key={componentKey}>
                <label>{name}</label>
                <input type="text" name={componentKey}>{children}</input>
            </div>
        )
    } else if (type.toLowerCase().includes("bigint")) {
        return (
            <div key={componentKey}>
                <label>{name}</label>
                <input type="text" name={componentKey}>{children}</input>
            </div>
        )
    } else if (type.toLowerCase().includes("int")) {
        return (
            <div key={componentKey}>
                <label>{name}</label>
                <input type="text" name={componentKey}>{children}</input>
            </div>
        )
    } else if (type.toLowerCase().includes("tinyint")) {
        return (
            <div key={componentKey}>
                <label>{name}</label>
                <input key={componentKey} type="checkbox" value={name} name={componentKey}>{children}</input>
            </div>
        )
    } else if (type.toLowerCase().includes("date")) {
        return (
            <div key={componentKey}>
                <label>{name}</label>
                <input key={componentKey} type="date" name={componentKey}>{children}</input>
            </div>
        )
    }

    return <div key={componentKey}>{children}</div>;
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