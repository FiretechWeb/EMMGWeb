import { GlobalVars } from "../cfg/config";
import axios from "axios";
import { splitFirstOccurrence } from "./stringExt";
import type { DBFieldType } from "./db_types";

let _dbStructure: any = null;

export class DBActions {

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

    static toParams(paramsArgs: string[]): Object {
        let params: { [key: string]: any } = {
            'fields': {},
            'keys' : {},
            'conditions': []
        };
        paramsArgs.forEach(arg => {
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