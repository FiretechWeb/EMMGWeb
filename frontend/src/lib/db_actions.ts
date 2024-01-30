import { GlobalVars } from "../cfg/config";
import axios from "axios";
import { splitFirstOccurrence } from "./stringExt";
import type { DBFieldType, DBForeignKey } from "./db_types";

let _dbStructure: any = null;

export class DBActions {

    /*
    *   Receives field data and a input string with the format: "text {fieldName} text 2"... 
    */
    static parseFieldFormat(input: string, data: { [key: string]: any }): string {
        return input.replace(/\{([^}]+)\}/g, (match, fieldName) => {
            const fieldValue = data[fieldName.trim()];
            return typeof fieldValue !== 'undefined' ? String(fieldValue) : match;
        });
    }

    static displayField(table: string, field: string, fieldsData: { [key: string]: any }, dbStructure: any = null) {
        if (!dbStructure) {
            dbStructure = _dbStructure;
        }
        if (!fieldsData[field]) return null;

        if (!dbStructure || !dbStructure[table] || !dbStructure[table]['fields']) return fieldsData[field];

        const tableFields = dbStructure[table]['fields'];

        if (!tableFields[field]) {
            return fieldsData[field];
        }
        const fieldParams: DBFieldType = tableFields[field] as DBFieldType;

        if (!fieldParams.foreign_key || !fieldParams.foreign_key.format) {
            return fieldsData[field];
        }

        let foreignData: any = {};

        Object.keys(fieldsData)
            .filter(fName => fName.trim().startsWith(`_${fieldParams.foreign_key?.table}_`))
            .forEach(fName => {
                foreignData[fName.trim().replace(`_${fieldParams.foreign_key?.table}_`, "")] = fieldsData[fName];
            });

        return DBActions.parseFieldFormat(fieldParams.foreign_key.format, foreignData);
    }

    static generateKeyFromField(fieldData: any, primaryKeys: Array<string>): string {
        return primaryKeys.map( key => fieldData[key]).join('-');
    }

    static isDataToSendValid(fieldValues: any, tableFields: any) : boolean {
        return !Object.keys(tableFields)
            .filter(fieldName => tableFields[fieldName].allow_insert && tableFields[fieldName].not_null)
            .some(fieldName => {
            if (fieldValues[fieldName] === null || fieldValues[fieldName] === undefined)
                return true;
            if (typeof fieldValues[fieldName] === "string" && (fieldValues[fieldName] as string).trim().length <= 0) {
                return true;
            }
            return false;
        });
    }
    
    static getPrimaryKeys(table: string, dbStructure: any = null): Array<string> {
        if (!dbStructure) {
            dbStructure = _dbStructure;
        }

        if (!dbStructure || !dbStructure[table] || !dbStructure[table]['fields']) return [];

        const tableFields = dbStructure[table]['fields'];

        return Object.keys(tableFields).filter( fieldName => {
            return (tableFields[fieldName] as DBFieldType).primary;
        });
    }  

    static async createMainDB() {
        try {
            let res = await axios.post(`${GlobalVars.backend_path!}/create_db.php`, { },
            {
                headers: {
                    'Content-Type': 'application/json',
                }
            });
            if (res.status === 404) {
                console.error("404 response");
                return null;
            } else {
                return res.data;
            }
        } catch (e) {
            console.error(e);
            return null;
        }
    }

    static setStructure(structure: any) {
        _dbStructure = structure;
    }
    static getTableGroups(dbStructure: any = null) {
        if (!dbStructure) {
            dbStructure = _dbStructure;
        }
        let tableGroups: any = {};
        Object.keys(dbStructure).forEach( tableName => {
            const groupName: string = dbStructure[tableName]['group'] ?? "_nogroup_";
            if (!tableGroups[groupName]) {
                tableGroups[groupName] = {};
            }
            tableGroups[groupName][tableName] = dbStructure[tableName];
        });
        console.log(tableGroups);
        return tableGroups;
    }
    static async getStructure() {
        try {
            let res = await axios.post(`${GlobalVars.backend_path!}/api/get_structure.php`, { },
            {
                headers: {
                    'Content-Type': 'application/json',
                }
            });
            if (res.status === 404) {
                console.error("404 response");
                return null;
            } else {
                if (res.data && res.data.data) {
                    _dbStructure = res.data.data;
                } else {
                    _dbStructure = null;
                }
                return res.data;
            }
        } catch (e) {
            console.error(e);
            return null;
        }
    }

    /**
     * Send an action to the backend API
     *
     * @param table name of the table in the database
     * @param action name of the action to execute
     * @param params optional params in the format of field: field_name = value or cond: field condition_statement result.
     * Format of action params:
     * {
     *  'fields': { 'fieldName': value, ...},
     *  'conditions': [{'field': field, 'condition': conditionString, 'result': result}, ...]
     * } 
    */
    static async process(table: string, action: string, params: Object) {
        console.log(`DBAction.process: ${table} - ${action}`, params);
        try {
            let res = await axios.post(`${GlobalVars.backend_path!}/api/action.php`, {
                table,
                action,
                params
             },
            {
                headers: {
                    'Content-Type': 'application/json',
                }
            });
            if (res.status === 404) {
                console.error("404 response");
                return null;
            } else {
                return res.data;
            }
        } catch (e) {
            console.error(e);
            return null;
        }
    }

    static foreignRelatedDataExists(field: DBFieldType, fieldsData: any) {
        if (!field || !field.foreign_key || !field.foreign_key.extra_relation)
            return false;

        const relatedTables: Array<string> = field.foreign_key.extra_relation.split(',');

        if (relatedTables.length < 1) return false;

        return relatedTables.every(relatedString => {
            const extraRelatedData: Array<string> = relatedString.split(':');
            if (extraRelatedData.length < 2) {
                return false;
            }
    
            const [foreingFieldName, fieldName] = extraRelatedData;
    
            return fieldsData[fieldName] != null && fieldsData[fieldName] != undefined;
        });
    }
    static shouldUpdateForeignList(field: DBFieldType, prevFieldsData: any, currentFieldsData: any): boolean {
        if (!DBActions.foreignRelatedDataExists(field, currentFieldsData)) 
            return false;

        const relatedTables: Array<string> = field.foreign_key!.extra_relation!.split(',');

        return relatedTables.some(relatedString => {
            const [foreingFieldName, fieldName] = relatedString.split(':');

            return !prevFieldsData[fieldName] || (currentFieldsData[fieldName] != prevFieldsData[fieldName]);
        });
    }

    static foreignKeyGetParams(field: DBFieldType, fieldsData: any) {
        let r: any = {
            'fields': {},
            'keys' : {},
            'conditions': [],
            'related_data': false
        };
        
        if (!DBActions.foreignRelatedDataExists(field, fieldsData)) 
            return r;

        const relatedTables: Array<string> = field.foreign_key!.extra_relation!.split(',');
        let returnResult = false;

        r['conditions'] = relatedTables.map(relatedString => {
            const [foreingFieldName, fieldName] = relatedString.split(':');
            const fieldValue: any = fieldsData[fieldName];

            return {
                'field': foreingFieldName,
                'condition': '=',
                'result': fieldValue
            };
        });

        return r;
    }

    static toParams(paramsArgs: string[]): Object {
        let params: { [key: string]: any } = {
            'fields': {},
            'keys' : {},
            'conditions': [],
            'related_data': false
        };
        paramsArgs.forEach(arg => {
            if (arg.trim().toLocaleLowerCase() == 'related_data') {
                params['related_data'] = true;
                return;
            }
            let fieldData: string[] = splitFirstOccurrence(arg, ':').map(e => e.trim());
            switch(fieldData[0]) {
                case 'field':
                case 'key':
                    let data = splitFirstOccurrence(fieldData[1], '=').map(e => e.trim());
                    let fieldName: string = data[0];
                    let fieldValue: string = data[1];
                    if (fieldData[0] == 'field') {
                        params['fields'][fieldName] = fieldValue;
                    } else {
                        params['keys'][fieldName] = fieldValue;
                    }
                break;
                case 'if':
                    params['conditions'].push(DBActions.toConditionObject(fieldData[1]));
                break;
                
            }
        });
        return params;
    }
    
    static toConditionObject(inputString: string): Object {
        const regex = /^(\S+)\s+(\S+)\s+(.+)/;
    
        const matchResult = inputString.match(regex);
    
        if (matchResult) {
            const fieldName = matchResult[1].trim();
            const conditionString = matchResult[2].trim();
            const resultValue = matchResult[3].trim();
            return {
                'field': fieldName,
                'condition': conditionString,
                'result': resultValue
            }
        } else {
            return {};
        }
    }
}