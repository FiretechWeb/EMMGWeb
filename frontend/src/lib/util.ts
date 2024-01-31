export function groupStringToObject(groupsString: string, objectData: any, splitChar: string = '>') {
    const array: Array<string> =  groupsString.split(splitChar);
    let arrayObj: any = {};
    let currentObj: any = arrayObj;
    for (let i=0; i < array.length; i++) {
        let element: string = array[i];
        currentObj[element] = (i === array.length-1) ? {...objectData} : {};
        currentObj = currentObj[element];
    }

    return arrayObj;
}

export function mergeObjects(obj1: any, obj2: any) {
    const merged: any = {};
    for (let key in obj1) {
        if (obj2.hasOwnProperty(key)) {
            if (typeof obj1[key] === 'object' && typeof obj2[key] === 'object') {
                merged[key] = mergeObjects(obj1[key], obj2[key]);
            } else {
                merged[key] = { ...obj1[key], ...obj2[key] };
            }
        } else {
            merged[key] = obj1[key];
        }
    }
    for (let key in obj2) {
        if (!obj1.hasOwnProperty(key)) {
            merged[key] = obj2[key];
        }
    }
    return merged;
}

const obj1 = {
    grupoA: {
        subgrupo1: { 'empresas': {}, 'empleados': {} },
        subgrupo2: { 'accesorios': {} }
    },
    grupoB: {
        subgrupo1: { 'tareas': {} },
        subgrupo2: { 'nombres': {} }
    }
};

const obj2 = {
    grupoA: {
        subgrupo2: { 'cabecales': {} }
    },
    grupoB: {
        subgrupo1: { 'ideas': {} },
        subgrupo3: { 'animales': {} }
    }
};