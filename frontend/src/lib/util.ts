export function arrayToObject(array: Array<string>, objectData: any) {
    let arrayObj: any = {};
    let currentObj: any = arrayObj;
    for (let i=0; i < array.length; i++) {
        let element: string = array[i];
        currentObj[element] = {};
        currentObj = currentObj[element];
    }

    currentObj = objectData;
    return arrayObj;
}