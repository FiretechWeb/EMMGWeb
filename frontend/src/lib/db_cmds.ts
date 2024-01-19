import axios from "axios";
import { addCMD, processCMD } from "./cmds";
import { GlobalVars } from "../cfg/config";
import { splitFirstOccurrence } from "./stringExt";
import type { cmdType } from "./cmds";


function processActionCondition(inputString: string): Object {
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

export function createDBcmds() {
    addCMD(
        {
            name: 'init db',
            usage:'used to initialize db',
            multiArgs: false,
            callback: () => {
                axios.post(`${GlobalVars.backend_path!}/create_db.php`, { },
                {
                    headers: {
                        'Content-Type': 'application/json',
                    }
                }).then(r => {
                    processCMD(`echo ${JSON.stringify(r.data, null, 3)}`);
                })
                .catch(e => processCMD(`echo ${e}`));
            }
        } as cmdType
    );


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

    addCMD(
        {
            name: 'action',
            usage:'action <<table>>, <<action>>, ...<<field: field_name = value>>, <<cond: field COND value>>',
            multiArgs: true,
            callback: (table: string, action: string, ...args: string[]) => {
                let params: { [key: string]: any } = {
                    'fields': {},
                    'conditions': []
                };
                args.forEach(arg => {
                    let fieldData: string[] = splitFirstOccurrence(arg, ':').map(e => e.trim());
                    switch(fieldData[0]) {
                        case 'field':
                            let data = splitFirstOccurrence(fieldData[1], '=').map(e => e.trim());
                            let fieldName: string = data[0];
                            let fieldValue: string = data[1];
                            params['fields'][fieldName] = fieldValue;
                        break;
                        case 'if':
                            params['conditions'].push(processActionCondition(fieldData[1]));
                        break;
                    }
                });
                axios.post(`${GlobalVars.backend_path!}/api/action.php`, {
                    table,
                    action,
                    params
                },
                {
                    headers: {
                        'Content-Type': 'application/json',
                    }
                }).then(r => {
                    processCMD(`echo ${JSON.stringify(r.data, null, 3)}`);
                })
                .catch(e => processCMD(`echo ${e}`));
            }
        } as cmdType
    );
}