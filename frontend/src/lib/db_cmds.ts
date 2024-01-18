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
            name: 'obra social',
            usage:'obra social <<accion>>, <<codigo | optional>>, <<nombre | optional>>',
            multiArgs: true,
            callback: (accion: string, code: string, nombre: string) => {
                axios.post(`${GlobalVars.backend_path!}/api/obra_social.php`, {
                    action: accion,
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
}