'use client';

import { processCMD, addCMD, cmdType, removeCMD } from '../lib/cmds';
import { createDBcmds } from '../lib/db_cmds';
import styles from './console.module.css';

import { MutableRefObject, useEffect, useRef } from 'react';

function consoleTextInput(inputText: string) {
    processCMD(inputText.trim());
}

export default function Console() {
    const consoleRef: MutableRefObject<null|HTMLFormElement> = useRef(null);
    const initialized: MutableRefObject<boolean> = useRef(false);
    const inputRef: MutableRefObject<null|HTMLInputElement> = useRef(null);
    const outputRef: MutableRefObject<null|HTMLTextAreaElement> = useRef(null);

    const handleConsoleInput = (e: KeyboardEvent) => {
        if (e.key === 'Enter') {
            const inputText: string = inputRef.current!.value;
            outputRef.current!.value += `> ${inputText}\n`;
            inputRef.current!.value = "";
            consoleTextInput(inputText);
            requestAnimationFrame(() => {
                outputRef.current!.scrollTop = outputRef.current!.scrollHeight;
            });
        }
    }

    useEffect(() => {
        if (initialized.current || !consoleRef.current) return;
    
        const inputElement = inputRef.current as HTMLInputElement;

        const formElement: HTMLFormElement = (consoleRef.current as HTMLFormElement);
        formElement.addEventListener('submit', (e) => {
            e.preventDefault();
        });

        inputElement.removeEventListener('keydown', handleConsoleInput);
        inputElement.addEventListener('keydown', handleConsoleInput);
        
        createDBcmds();

        removeCMD('clear');
        addCMD({
            name: 'clear',
            usage:'clear console',
            multiArgs: false,
            callback: () => {outputRef.current!.value = "";}
        } as cmdType);

        removeCMD('echo');
        addCMD({
            name: 'echo',
            usage: 'print message to console',
            multiArgs: false,
            callback: (txt: string) => {
                outputRef.current!.value += `${txt}\n`; console.log(txt);
                requestAnimationFrame(() => {
                    outputRef.current!.scrollTop = outputRef.current!.scrollHeight;
                });
            }
        } as cmdType);

        initialized.current = true;
    }, [inputRef, outputRef]);

    return (
        <form className={styles.wrapper} ref={consoleRef}>
            <textarea ref={outputRef} readOnly className={styles.output}></textarea>
            <input ref={inputRef} className={styles.input} type="text"></input>
        </form>
    )
}