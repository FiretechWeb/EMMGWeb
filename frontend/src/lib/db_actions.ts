import { GlobalVars } from "../cfg/config";
import axios from "axios";
import { splitFirstOccurrence } from "./stringExt";

let _dbStructure: any = null;

export class DBActions {

    static getPrimaryKeyName(table: string, dbStructure: any = null) {
        if (!dbStructure) {
            dbStructure = _dbStructure;
        }
        
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
                _dbStructure = res.data;
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
            'conditions': []
        };
        paramsArgs.forEach(arg => {
            let fieldData: string[] = splitFirstOccurrence(arg, ':').map(e => e.trim());
            switch(fieldData[0]) {
                case 'field':
                    let data = splitFirstOccurrence(fieldData[1], '=').map(e => e.trim());
                    let fieldName: string = data[0];
                    let fieldValue: string = data[1];
                    params['fields'][fieldName] = fieldValue;
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