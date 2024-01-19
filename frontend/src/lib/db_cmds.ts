import { addCMD, processCMD } from "./cmds";
import type { cmdType } from "./cmds";
import { DBActions } from "./db_actions";

export function createDBcmds() {
    addCMD(
        {
            name: 'init db',
            usage:'used to initialize db',
            multiArgs: false,
            callback: async () => {
                processCMD(`echo ${JSON.stringify(await DBActions.createMainDB(), null, 3)}`);
            }
        } as cmdType
    );

    addCMD(
        {
            name: 'get structure',
            usage:'get API DB structure',
            multiArgs: false,
            callback: async () => {
                processCMD(`echo ${JSON.stringify(await DBActions.getStructure(), null, 3)}`);
            }
        } as cmdType
    );

    addCMD(
        {
            name: 'action',
            usage:'action <<table>>, <<action>>, ...<<field: field_name = value>>, <<cond: field COND value>>',
            multiArgs: true,
            callback: async (table: string, action: string, ...args: string[]) => {
                processCMD(`echo ${JSON.stringify(await DBActions.process(table, action, DBActions.toParams(args)), null, 3)}`);
            }
        } as cmdType
    );
}