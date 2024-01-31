import type { DBFieldType } from "../lib/db_types"
import { useState, useEffect, useRef } from "react"
import { InputText } from 'primereact/inputtext';
import { InputNumber } from 'primereact/inputnumber';
import { Checkbox } from 'primereact/checkbox';
import { Calendar } from 'primereact/calendar';
import { DBActions } from "../lib/db_actions";
import { Dropdown } from "primereact/dropdown";
import { MutableRefObject } from "react";
import { useErrorState, useCurrentTableState, usePreviousTableState, useUIActionState, UIActionStates } from "../lib/global_store";

interface FieldComponentProps {
    name: string;
    jsonFieldData: string;
    value?: any;
    onValueChanged?: Function;
}

export default function FieldComponent(props: FieldComponentProps) {
    const initialized: MutableRefObject<boolean> = useRef(false);
    const foreignListInit: MutableRefObject<boolean> = useRef(false);


    const [fieldData, setFieldData] = useState<DBFieldType | null>(null);
    const [fieldSelected, setFieldSelected] = useState<any>(null);
    const [fieldForeignOptions, setFieldForeignOptions] = useState<Array<any>>([]);
    const [fieldValue, setFieldValue] = useState<any>(null);
    const tableFieldsData = useCurrentTableState((state) => state.data);
    const prevTableFieldsData = usePreviousTableState((state) => state.data);
    const actionState = useUIActionState((state) => state.state);
    const [isDisabled, setIsDisabled] = useState<boolean>(false);

    const setErrorState = useErrorState((state) => state.setError);

    const updateFieldValue = (value: any) => {
        setFieldValue(value);
        if (props.onValueChanged) {
            props.onValueChanged(props.name, value);
        }
    }

    const updateFieldSelected = (selectedField: any) => {
        setFieldSelected(selectedField);
        if (props.onValueChanged) {
            props.onValueChanged(props.name, selectedField.code);
        }
    }
    const updateDropdownList = () => {
        if (!fieldData || !fieldData.foreign_key) return;
        console.log("UPDATE");

        DBActions.process(fieldData.foreign_key.table, "get", DBActions.foreignKeyGetParams(fieldData, tableFieldsData))
            .then(r => {
                if (r && r.data) {
                    setFieldForeignOptions(r.data.map( (e: any) => { 
                        return {
                            name: fieldData.foreign_key!.format ? 
                                DBActions.parseFieldFormat(fieldData.foreign_key!.format, e) : JSON.stringify(e),
                            code: e[fieldData.foreign_key!.field]
                        }
                    }));
                } else {
                    setErrorState(`Invalid response type or data: ${props.name} - Foreign: ${fieldData.foreign_key!.table}`)
                    setFieldForeignOptions([]);
                }
            }).catch(e => {
                setErrorState(e);
                setFieldForeignOptions([]);
            });
    }

    useEffect(() => {
        if (!fieldData || !fieldData.enabled_by || !tableFieldsData.hasOwnProperty(fieldData.enabled_by)) {
            return;
        }
        setIsDisabled(!tableFieldsData[fieldData.enabled_by]);
    }, [tableFieldsData, fieldData]);

    useEffect(() => {
        if (!fieldData || !fieldData.foreign_key) return;

        if (!fieldData.foreign_key.extra_relation && foreignListInit.current) return;

        if (!fieldData.foreign_key.extra_relation || (actionState == UIActionStates.MODIFY && !foreignListInit.current) || DBActions.shouldUpdateForeignList(fieldData, prevTableFieldsData, tableFieldsData)) {
            foreignListInit.current = true;
            updateDropdownList();
        }

    }, [tableFieldsData, fieldData, prevTableFieldsData]);

    useEffect(() => {
        if (fieldValue) {
            setFieldSelected(fieldForeignOptions.find(fo => fo.code == fieldValue));
        }
    }, [fieldForeignOptions]);

    useEffect(() => {
        
        if (initialized.current) return;

        updateFieldValue(props.value);
        if (props.jsonFieldData) {
            setFieldData(JSON.parse(props.jsonFieldData) as DBFieldType);
        }

        initialized.current = true;
    }, [props, fieldData]);

    return (
        <>
        {
            fieldData && fieldData && fieldData.foreign_key && 
            <div className="m-2">
                <label className="mx-2">{fieldData.display_name ?? props.name}: </label>
                <Dropdown disabled={isDisabled} filter value={fieldSelected} onChange={(e) => updateFieldSelected(e.value)} options={fieldForeignOptions} placeholder="Seleccionar" optionLabel="name" ></Dropdown>
            </div>

        }
        {
            fieldData && fieldData && !fieldData.foreign_key && 
            fieldData.sql_type.toLowerCase().includes("varchar") &&
            <div className="m-2">
                <label className="mx-2">{fieldData.display_name ?? props.name}: </label>
                <InputText disabled={isDisabled} name={props.name} autoComplete="off" aria-autocomplete="none" onChange={(e) => updateFieldValue(e.target.value)} value={fieldValue as string} ></InputText>
            </div>
        }
        {
             fieldData && fieldData && !fieldData.foreign_key && 
            (fieldData.sql_type.toLowerCase().includes("bigint") ||
            fieldData.sql_type.toLowerCase().includes("int")) &&
            !fieldData.sql_type.toLowerCase().includes("tinyint") &&
            <div className="m-2">
                <label className="mx-2">{fieldData.display_name ?? props.name}: </label>
                <InputNumber disabled={isDisabled} name={props.name} useGrouping={false} aria-autocomplete="none" onChange={(e) => updateFieldValue(e.value)} value={fieldValue as number}></InputNumber>
            </div>
        }
        {
             fieldData && fieldData && !fieldData.foreign_key && 
            fieldData.sql_type.toLowerCase().includes("decimal") &&
            <div className="m-2">
                <label className="mx-2">{fieldData.display_name ?? props.name}: </label>
                <InputNumber disabled={isDisabled} name={props.name} aria-autocomplete="none" onChange={(e) => updateFieldValue(e.value)} value={fieldValue as number} minFractionDigits={2} maxFractionDigits={2}></InputNumber>
            </div>
        }
        {
            fieldData && fieldData && !fieldData.foreign_key && 
            fieldData.sql_type.toLowerCase().includes("tinyint") &&
            <div className="m-2">
                <label className="mx-2">{fieldData.display_name ?? props.name}: </label>
                <Checkbox disabled={isDisabled} onChange={e => updateFieldValue(!fieldValue)} name={props.name} checked={fieldValue as boolean}></Checkbox>
            </div>
        }
        {
            fieldData && fieldData && !fieldData.foreign_key && 
            fieldData.sql_type.toLowerCase().includes("date") &&
            <div className="m-2">
                <label className="mx-2">{fieldData.display_name ?? props.name}: </label>
                <Calendar disabled={isDisabled} name={props.name} onChange={(e) => updateFieldValue(e.value)} value={fieldValue as Date}></Calendar>
            </div>
        }
        </>
    )
}