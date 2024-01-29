import FieldComponent from "./field";
import { DBFieldType } from "../lib/db_types";
import { useEffect, useState } from "react";

interface DBTableFields {
    fieldsList: any;
    onValueChanged?: Function;
    fieldsValues?: any;
}

export function DBTableFields(props: DBTableFields) {
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});

    useEffect(() => {
        setFields(props.fieldsList);
    }, []);
    return (
        <div>
        {
        Object.keys(fields).length > 0 && Object.keys(fields)
            .filter(fieldName => fields[fieldName].allow_insert)
            .map( (fieldName) => (
                <FieldComponent key={fieldName} name={fieldName} onValueChanged={props.onValueChanged} jsonFieldData={JSON.stringify(fields[fieldName])} value={(props.fieldsValues && props.fieldsValues[fieldName]) ?? null }></FieldComponent>
            ))
        }
        </div>
    )
}