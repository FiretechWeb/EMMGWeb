import { create } from 'zustand'

interface ErrorState {
    error: string;
    setError: (value: string) => void;
    getError: () => string;
    cleanError: () => void;
}
interface SuccessState {
    success: string;
    setSuccess: (value: string) => void;
    getSuccess: () => string;
    cleanSuccess: () => void;
}

export enum UIActionStates {
    NONE,
    ADD,
    MODIFY,
    DELETE
}

interface UIActionState {
    state: UIActionStates;
    setUIActionState: (value: UIActionStates) => void;
    getUIActionState: () => UIActionStates;
}


const errorDefinition = (
    set: (
        partial:
        | ErrorState
        | Partial<ErrorState>
        | ((state: ErrorState) => ErrorState | Partial<ErrorState>),
        replace?: boolean | undefined
    ) => void,
    get: () => ErrorState
    ) => ({
    error: "",
    setError: (value: string) => set({ error: value }),
    getError: () => get().error,
    cleanError: () => set({ error: "" }),
} as ErrorState);

const sucessDefinition = (
    set: (
        partial:
        | SuccessState
        | Partial<SuccessState>
        | ((state: SuccessState) => SuccessState | Partial<SuccessState>),
        replace?: boolean | undefined
    ) => void,
    get: () => SuccessState
    ) => ({
    success: "",
    setSuccess: (value: string) => set({ success: value }),
    getSuccess: () => get().success,
    cleanSuccess: () => set({ success: "" }),
} as SuccessState);

const actionStateDefinition = (
    set: (
        partial:
        | UIActionState
        | Partial<UIActionState>
        | ((state: UIActionState) => UIActionState | Partial<UIActionState>),
        replace?: boolean | undefined
    ) => void,
    get: () => UIActionState
    ) => ({
    state: UIActionStates.NONE,
    setUIActionState: (value: UIActionStates) => set({ state: value }),
    getUIActionState: () => get().state,
} as UIActionState);

export const useErrorState = create<ErrorState>(errorDefinition);
export const useSuccessState = create<SuccessState>(sucessDefinition);
export const useUIActionState = create<UIActionState>(actionStateDefinition);