import type { DBFieldType, DBTableType } from "../lib/db_types"
import { useState, useEffect, MutableRefObject, useRef } from "react"
import { Button } from "primereact/button";
import { DBActions } from "../lib/db_actions";
import { useErrorState, useSuccessState, useUIActionState, UIActionStates, useCurrentTableState, usePreviousTableState } from "../lib/global_store";
import { DBTableFields } from "./table_fields";
import { Accordion, AccordionTab } from "primereact/accordion";

interface TableAddComponentProps {
    jsonTableData: string;
    tableName: string;
}

interface CSSTransitionProps {
    in: boolean;
    timeout: number;
    classNames: string | { enter: string; enterActive: string; exit: string; exitActive: string };
    unmountOnExit?: boolean;
    mountOnEnter?: boolean;
}

export default function TableAddComponent(props: TableAddComponentProps) {
    
    const [fieldsGroups, setFieldsGroups] = useState<{ [fieldGroupName: string]: Array<string>; }>({});
    const [fields, setFields] = useState<{ [fieldName: string]: DBFieldType; }>({});
    const initialized: MutableRefObject<boolean> = useRef(false);
    const fieldsData: MutableRefObject<any> = useRef({});

    const [displayName, setDisplayName] = useState<string>("");
    const setErrorState = useErrorState((state) => state.setError);
    const setSuccessState = useSuccessState((state) => state.setSuccess);
    const setActionState = useUIActionState((state) => state.setUIActionState);
    const setTableFieldsData = useCurrentTableState((state) => state.setData);
    const setPrevTableFieldsData = usePreviousTableState((state) => state.setData);
    const tableFieldsData = useCurrentTableState((state) => state.data);

    const addElement = (event: any) => {

        if (DBActions.isDataToSendValid(fieldsData.current, fields)) {
            DBActions.process(props.tableName, "insert", {
                'fields': fieldsData.current,
                'conditions': [],
                'keys': {}
            }).then(r => {
                if (!r.res) {
                    setErrorState(`FATAL ERROR: ${r}`);
                } else if (r.msg && r.res == 'error') {
                    setErrorState(r.msg)
                } else if (r.res == 'ok') {
                    setSuccessState("Data added correctly.");
                    setActionState(UIActionStates.NONE);
                } else {
                    setErrorState(`Invalid response type. ${r}`);
                }
                
            }).catch(e => setErrorState(e));
        } else {
            setErrorState("Missing fields or values to send data");
        }

        event.preventDefault();
    };

    const onFieldValueChanged = (fieldName: string, value: any) => {
        fieldsData.current[fieldName] = value;
        setPrevTableFieldsData({...tableFieldsData});
        setTableFieldsData({...fieldsData.current});
    }

    useEffect(() => {
        if (initialized.current) return;
        
        const decodedTableData: any = JSON.parse(props.jsonTableData);
        const fieldGroups: any = decodedTableData['field_groups'];
        const tmpFieldData = decodedTableData['fields'];
        if (fieldGroups) {
            let fieldGroupsData: any = {};
            Object.keys(fieldGroups).forEach(fieldGroupName => {
                if (!fieldGroupsData[fieldGroupName]) {
                    fieldGroupsData[fieldGroupName] = {};
                }
                const fieldNames: Array<string> = fieldGroups[fieldGroupName];
                fieldNames.forEach(fieldName => fieldGroupsData[fieldGroupName][fieldName] = tmpFieldData[fieldName]);
            });
            setFieldsGroups(fieldGroupsData);
        }
        setFields(tmpFieldData);
       
        setDisplayName(decodedTableData['display_name'] ?? props.tableName);

        initialized.current = true;
    }, [props]);

    return (
        <div>
            <h3 className="text-xl font-bold">Agregar {displayName}</h3>
        <form className="flex flex-col" autoComplete="off">
        {
            Object.keys(fieldsGroups).length <= 0 && Object.keys(fields).length > 0 && <DBTableFields fieldsList={fields} onValueChanged={onFieldValueChanged}></DBTableFields>
        }
        {
            Object.keys(fieldsGroups).length > 0 && Object.keys(fields).length > 0 && 
            <Accordion multiple activeIndex={0} transitionOptions={{ unmountOnExit: false } as CSSTransitionProps}>
            {
            Object.keys(fieldsGroups).map(fieldGroupName => (
                <AccordionTab key={fieldGroupName} header={            
                <span className="flex items-center h-14">
                <span className="font-bold white-space-nowrap">{fieldGroupName}</span>
                </span>
                }>
                    <DBTableFields fieldsList={fieldsGroups[fieldGroupName]} onValueChanged={onFieldValueChanged}></DBTableFields>
                </AccordionTab>))
            }
            </Accordion>
        }
        <Button onClick={addElement} className="bg-slate-500 p-1 m-1 self-center place-self-center" label="Agregar"></Button>
        </form>
        </div>
    )
}