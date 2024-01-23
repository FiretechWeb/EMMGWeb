import type { DBFieldType, DBTableType } from "../lib/db_types"
import { useState, useEffect, MutableRefObject, useRef } from "react"
import TableAddComponent from "./table_add";
import TableModifyComponent from "./table_modify";
import TableDeleteComponent from "./table_delete";
import { Button } from "primereact/button";

interface TableComponentProps {
    jsonTableData: string;
    name: string;
}

enum UIActionStates {
    NONE,
    ADD,
    MODIFY,
    DELETE
}

export default function DBTableComponent(props: TableComponentProps) {
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});
    const [actionState, setActionState] = useState<UIActionStates>(UIActionStates.NONE);
    const initialized: MutableRefObject<boolean> = useRef(false);
    useEffect(() => {
        if (initialized.current) return;

        setFields(JSON.parse(props.jsonTableData)['fields']);

        initialized.current = true;
    }, [props]);

    return(
        <div>
            <h2 className="text-3xl font-bold m-1 text-center">{props.name}</h2>
            {
                actionState === UIActionStates.ADD &&
                <TableAddComponent name={props.name} jsonTableData={props.jsonTableData}></TableAddComponent>
            }
            {
                actionState === UIActionStates.MODIFY &&
                <TableModifyComponent name={props.name} jsonTableData={props.jsonTableData}></TableModifyComponent>
            }
            {
                actionState === UIActionStates.DELETE &&
                <TableDeleteComponent name={props.name} jsonTableData={props.jsonTableData}></TableDeleteComponent>
            }
            <hr />
            <div className="flex flex-row items-center text-center place-items-center place-content-center content-center justify-center">
            {
                actionState === UIActionStates.NONE &&
                <Button onClick={() => setActionState(UIActionStates.ADD)} className="bg-slate-500 p-1 m-1 self-center place-self-center" label="Agregar"></Button>
            }
            {
                actionState === UIActionStates.NONE &&
                <Button onClick={() => setActionState(UIActionStates.MODIFY)} className="bg-slate-500 p-1 m-1 self-center place-self-center" label="Modificar"></Button>
            }
            {
                actionState === UIActionStates.NONE &&
                <Button onClick={() => setActionState(UIActionStates.DELETE)} className="bg-slate-500 p-1 m-1 self-center place-self-center" label="Eliminar"></Button>
            }
            {
                actionState !== UIActionStates.NONE &&
                <Button onClick={() => setActionState(UIActionStates.NONE)} className="bg-slate-500 p-1 m-1 self-center place-self-center" label="Volver"></Button>
            }
            </div>
        </div>
    )
}