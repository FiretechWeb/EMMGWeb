import axios from "axios";
import { addCMD, processCMD } from "./cmds";
import { GlobalVars } from "../cfg/config";
import { splitFirstOccurrence } from "./stringExt";
import type { cmdType } from "./cmds";


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

    addCMD(
        {
            name: 'action',
            usage:'action <<table>>, <<action>>, ...<<param: value>>',
            multiArgs: true,
            callback: (table: string, action: string, ...args: string[]) => {
                let params: { [key: string]: any } = {};
                args.forEach(arg => {
                    let fieldData: string[] = splitFirstOccurrence(arg, ':').map(e => e.trim());
                    params[fieldData[0]] = fieldData[1];
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