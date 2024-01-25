import type { DBFieldType } from "../lib/db_types"
import { useState, useEffect, useRef } from "react"
import { InputText } from 'primereact/inputtext';
import { InputNumber } from 'primereact/inputnumber';
import { Checkbox } from 'primereact/checkbox';
import { Calendar } from 'primereact/calendar';
import { DBActions } from "../lib/db_actions";
import { Dropdown } from "primereact/dropdown";
import { MutableRefObject } from "react";

interface FieldComponentProps {
    name: string;
    jsonFieldData: string;
    value?: any;
    onValueChanged?: Function;
}

export default function FieldComponent(props: FieldComponentProps) {
    const initialized: MutableRefObject<boolean> = useRef(false);

    const [fieldData, setFieldData] = useState<DBFieldType | null>(null);
    const [fieldSelected, setFieldSelected] = useState<any>(null);
    const [fieldForeignOptions, setFieldForeignOptions] = useState<Array<any>>([]);
    const [fieldValue, setFieldValue] = useState<any>(null);

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

    useEffect(() => {
        
        if (initialized.current) return;

        updateFieldValue(props.value);

        setFieldData(JSON.parse(props.jsonFieldData) as DBFieldType);

        if (!fieldData) return;
        
        if (fieldData.foreign_key) {
            DBActions.process(fieldData.foreign_key.table, "get", DBActions.toParams([]))
                .then(r => {
                    if (r && r.data) {
                        setFieldForeignOptions(r.data.map( (e: any) => { 
                            return {
                                name: fieldData.foreign_key!.format ? 
                                    DBActions.parseFieldFormat(fieldData.foreign_key!.format, e) : JSON.stringify(e),
                                code: e[fieldData.foreign_key!.field]
                            }
                        }));
                        if (fieldValue) {
                            setFieldSelected(fieldForeignOptions.find(fo => fo.code == fieldValue));
                        }
                    } else {
                        setFieldForeignOptions([]);
                    }
                }).catch(e => setFieldForeignOptions([]));
        }

        initialized.current = true;
    }, [props, fieldData, fieldValue, fieldForeignOptions]);

    return (
        <>
        {
            fieldData && fieldData && fieldData.foreign_key && 
            <div className="m-2">
                <label className="mx-2">{fieldData.display_name ?? props.name}: </label>
                <Dropdown filter value={fieldSelected} onChange={(e) => updateFieldSelected(e.value)} options={fieldForeignOptions} placeholder="Seleccionar" optionLabel="name" ></Dropdown>
            </div>

        }
        {
            fieldData && fieldData && !fieldData.foreign_key && 
            fieldData.sql_type.toLowerCase().includes("varchar") &&
            <div className="m-2">
                <label className="mx-2">{fieldData.display_name ?? props.name}: </label>
                <InputText name={props.name} onChange={(e) => updateFieldValue(e.target.value)} value={fieldValue as string} ></InputText>
            </div>
        }
        {
             fieldData && fieldData && !fieldData.foreign_key && 
            (fieldData.sql_type.toLowerCase().includes("bigint") ||
            fieldData.sql_type.toLowerCase().includes("int")) &&
            !fieldData.sql_type.toLowerCase().includes("tinyint") &&
            <div className="m-2">
                <label className="mx-2">{fieldData.display_name ?? props.name}: </label>
                <InputNumber name={props.name} onValueChange={(e) => updateFieldValue(e.value)} value={fieldValue as number}></InputNumber>
            </div>
        }
        {
             fieldData && fieldData && !fieldData.foreign_key && 
            fieldData.sql_type.toLowerCase().includes("decimal") &&
            <div className="m-2">
                <label className="mx-2">{fieldData.display_name ?? props.name}: </label>
                <InputNumber name={props.name} onValueChange={(e) => updateFieldValue(e.value)} value={fieldValue as number} minFractionDigits={2} maxFractionDigits={2}></InputNumber>
            </div>
        }
        {
            fieldData && fieldData && !fieldData.foreign_key && 
            fieldData.sql_type.toLowerCase().includes("tinyint") &&
            <div className="m-2">
                <label className="mx-2">{fieldData.display_name ?? props.name}: </label>
                <Checkbox onChange={e => updateFieldValue(!fieldValue)} name={props.name} checked={fieldValue as boolean}></Checkbox>
            </div>
        }
        {
            fieldData && fieldData && !fieldData.foreign_key && 
            fieldData.sql_type.toLowerCase().includes("date") &&
            <div className="m-2">
                <label className="mx-2">{fieldData.display_name ?? props.name}: </label>
                <Calendar name={props.name} onChange={(e) => updateFieldValue(e.value)} value={fieldValue as Date}></Calendar>
            </div>
        }
        </>
    )
}