import type { DBFieldType, DBTableType } from "../lib/db_types"
import { useState, useEffect } from "react"
import { InputText } from 'primereact/inputtext';
import { InputNumber } from 'primereact/inputnumber';
import { Checkbox } from 'primereact/checkbox';
import { Calendar } from 'primereact/calendar';
import { DBActions } from "../lib/db_actions";
import { Dropdown } from "primereact/dropdown";

interface FieldComponentProps {
    name: string,
    jsonFieldData: string;

}

export default function FieldComponent(props: FieldComponentProps) {
    const [fieldData, setFieldData] = useState<DBFieldType | null>(null);
    const [fieldChecked, setFieldChecked] = useState<boolean>(false);
    const [fieldSelected, setFieldSelected] = useState<any>(null);
    const [fieldForeignOptions, setFieldForeignOptions] = useState<Array<any>>([]);
    useEffect(() => {
        setFieldData(JSON.parse(props.jsonFieldData) as DBFieldType);

        if (!fieldData) return;
        if (fieldData.foreign_key) {
            DBActions.process(fieldData.foreign_key.table, "get", DBActions.toParams([]))
                .then(r => {
                    if (r && r.data) {
                        setFieldForeignOptions(r.data.map( (e: any) => { 
                            return {
                                name: JSON.stringify(e),
                                code: e[fieldData.foreign_key!.field]
                            }
                        }));
                    } else {
                        setFieldForeignOptions([]);
                    }
                }).catch(e => setFieldForeignOptions([]));
        }
    }, [props]);

    return (
        <>
        {
            fieldData && fieldData && fieldData.foreign_key && 
            <div className="m-2">
                <label className="mx-2">{props.name}: </label>
                <Dropdown filter value={fieldSelected} onChange={(e) => setFieldSelected(e.value)} options={fieldForeignOptions} placeholder="Seleccionar" optionLabel="name" ></Dropdown>
            </div>

        }
        {
            fieldData && fieldData && !fieldData.foreign_key && 
            fieldData.sql_type.toLowerCase().includes("varchar") &&
            <div className="m-2">
                <label className="mx-2">{props.name}: </label>
                <InputText name={props.name} ></InputText>
            </div>
        }
        {
             fieldData && fieldData && !fieldData.foreign_key && 
            (fieldData.sql_type.toLowerCase().includes("bigint") ||
            fieldData.sql_type.toLowerCase().includes("int")) &&
            <div className="m-2">
                <label className="mx-2">{props.name}: </label>
                <InputNumber name={props.name} ></InputNumber>
            </div>
        }
        {
            fieldData && fieldData && !fieldData.foreign_key && 
            fieldData.sql_type.toLowerCase().includes("tinyint") &&
            <div className="m-2">
                <label className="mx-2">{props.name}: </label>
                <Checkbox onChange={e => setFieldChecked(!fieldChecked)} name={props.name} checked={fieldChecked}></Checkbox>
            </div>
        }
        {
            fieldData && fieldData && !fieldData.foreign_key && 
            fieldData.sql_type.toLowerCase().includes("date") &&
            <div className="m-2">
                <label className="mx-2">{props.name}: </label>
                <Calendar name={props.name}></Calendar>
            </div>
        }
        </>
    )
}