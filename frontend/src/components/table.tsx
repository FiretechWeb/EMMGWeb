import type { DBFieldType, DBTableType } from "../lib/db_types"
import { useState, useEffect } from "react"
import TableAddComponent from "./table_add";

interface TableComponentProps {
    jsonTableData: string;
    name: string;
}

export default function DBTableComponent(props: TableComponentProps) {
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});

    useEffect(() => {
        setFields(JSON.parse(props.jsonTableData)['fields']);
    }, [props]);

    return(
        <div>
            <h2 className="text-xl font-bold">{props.name}</h2>
                <TableAddComponent name={props.name} jsonTableData={props.jsonTableData}></TableAddComponent>
            <hr />
        </div>
    )
}