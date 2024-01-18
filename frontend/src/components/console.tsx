'use client';

import { processCMD, addCMD, cmdType } from '../lib/cmds';
import { createDBcmds } from '../lib/db_cmds';
import styles from './console.module.css';

import { MutableRefObject, useEffect, useRef } from 'react';

function consoleTextInput(inputText: string) {
    processCMD(inputText.trim());
}

export default function Console() {
    const consoleRef: MutableRefObject<null|HTMLFormElement> = useRef(null);
    const initialized: MutableRefObject<boolean> = useRef(false);
    useEffect(() => {
        if (initialized.current || !consoleRef.current) return;

        const formElement: HTMLFormElement = (consoleRef.current as HTMLFormElement);
        formElement.addEventListener('submit', (e) => {
            e.preventDefault();
        });

        const outputElement: HTMLTextAreaElement = formElement.querySelector("textarea") as HTMLTextAreaElement;
        const inputElement: HTMLInputElement = formElement.querySelector("input") as HTMLInputElement;
        inputElement.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                const inputText: string = inputElement.value;
                outputElement.value += `> ${inputText}\n`;
                inputElement.value = "";
                consoleTextInput(inputText);
                requestAnimationFrame(() => {
                    outputElement.scrollTop = outputElement.scrollHeight;
                });
              }
        });
        
        createDBcmds();
        
        addCMD({
            name: 'clear',
            usage:'clear console',
            multiArgs: false,
            callback: () => {outputElement.value = "";}
        } as cmdType);

        addCMD({
            name: 'echo',
            usage: 'print message to console',
            multiArgs: false,
            callback: (txt: string) => {
                outputElement.value += `${txt}\n`; console.log(txt);
                requestAnimationFrame(() => {
                    outputElement.scrollTop = outputElement.scrollHeight;
                });
            }
        } as cmdType);

        initialized.current = true;
    }, []);

    return (
        <form className={styles.wrapper} ref={consoleRef}>
            <textarea readOnly className={styles.output}></textarea>
            <input className={styles.input} type="text"></input>
        </form>
    )
}