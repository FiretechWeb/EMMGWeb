import type { DBFieldType } from "../lib/db_types"
import { useState, useEffect, MutableRefObject, useRef } from "react"
import TableAddComponent from "./table_add";
import TableModifyComponent from "./table_modify";
import TableDeleteComponent from "./table_delete";
import { Button } from "primereact/button";
import { useUIActionState, UIActionStates } from "../lib/global_store";


interface TableComponentProps {
    jsonTableData: string;
    tableName: string;
}

export default function DBTableComponent(props: TableComponentProps) {
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});
    const actionState: UIActionStates = useUIActionState((state) => state.state);
    const setActionState = useUIActionState((state) => state.setUIActionState);

    //const [actionState, setActionState] = useState<UIActionStates>(UIActionStates.NONE);
    const [displayName, setDisplayName] = useState<string>("");
    const initialized: MutableRefObject<boolean> = useRef(false);

    useEffect(() => {
        if (initialized.current) return;
        const tableData: any = JSON.parse(props.jsonTableData);
        setFields(tableData['fields']);
        setDisplayName(tableData['display_name'] ?? props.tableName);
        initialized.current = true;
    }, [props]);

    return(
        <div>
            <h2 className="text-3xl font-bold m-1 text-center">{displayName}</h2>
            {
                actionState === UIActionStates.ADD &&
                <TableAddComponent tableName={props.tableName} jsonTableData={props.jsonTableData}></TableAddComponent>
            }
            {
                actionState === UIActionStates.MODIFY &&
                <TableModifyComponent tableName={props.tableName} jsonTableData={props.jsonTableData}></TableModifyComponent>
            }
            {
                actionState === UIActionStates.DELETE &&
                <TableDeleteComponent tableName={props.tableName} jsonTableData={props.jsonTableData}></TableDeleteComponent>
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