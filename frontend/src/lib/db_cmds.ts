import axios from "axios";
import { addCMD, processCMD } from "./cmds";
import { GlobalVars } from "../cfg/config";
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
            name: 'add obra social',
            usage:'add obra social <<codigo>>, <<nombre>>',
            multiArgs: true,
            callback: (code: string, nombre: string) => {
                axios.post(`${GlobalVars.backend_path!}/api/obra_social.php`, {
                    action: 'insert',
                    code: parseInt(code),
                    nombre
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

    addCMD(
        {
            name: 'get obra social',
            usage:'get obra social <<codigo | optional>>, <<nombre | optional>>',
            multiArgs: true,
            callback: (code: string, nombre: string) => {
                axios.post(`${GlobalVars.backend_path!}/api/obra_social.php`, {
                    action: 'get',
                    code: code && code.length > 0 ? parseInt(code) : null,
                    nombre: nombre && nombre.length > 0 ? nombre : null
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