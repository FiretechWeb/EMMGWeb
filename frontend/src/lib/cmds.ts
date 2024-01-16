export interface cmdType {
    name: string,
    usage: string,
    callback: Function
}

const CMDS: cmdType[] = [];

export function addCMD(cmd: cmdType) {
    CMDS.push(cmd);
}

export function processCMD(cmdString: string) {
    CMDS.forEach((cmd: cmdType) => {
        if (cmdString.toLocaleLowerCase().startsWith(cmd.name)) {
            cmd.callback(...cmdString.slice(cmd.name.length-1, cmdString.length).split(',').map(arg => arg.trim()));
        }
    })
}