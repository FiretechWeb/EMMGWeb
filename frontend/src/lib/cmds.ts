import { GlobalVars } from "../cfg/config";
import axios from "axios";

export interface cmdType {
    name: string,
    usage: string,
    callback: Function,
    multiArgs: boolean
}

const CMDS: cmdType[] = [
    {
        name: 'help',
        usage:'returns a list with all the commands',
        multiArgs: false,
        callback: () => {
            CMDS.forEach(cmd => {
                processCMD(`echo ${cmd.name} - usage: ${cmd.usage}`);
            });
        }
    },
    {
        name: 'server test',
        usage:'server test <<id of test>>',
        multiArgs: false,
        callback: (id: string) => {
            axios.post(`${GlobalVars.backend_path!}/index.php`, { test_id: id },
            {
                headers: {
                    'Content-Type': 'application/json',
                  }
            }).then(r => {
                processCMD(`echo ${JSON.stringify(r.data, null, 3)}`);
            })
            .catch(e => processCMD(`echo ${e}`));
        }
    }
];

export function addCMD(cmd: cmdType) {
    CMDS.push(cmd);
}

export function processCMD(cmdString: string) {
    CMDS.forEach((cmd: cmdType) => {
        if (cmdString.toLocaleLowerCase().startsWith(cmd.name)) {
            if (cmd.multiArgs) {
                cmd.callback(...cmdString.slice(cmd.name.length, cmdString.length).split(',').map(arg => arg.trim()));
            } else {
                cmd.callback(cmdString.slice(cmd.name.length, cmdString.length).trim());
            }
        }
    });
}