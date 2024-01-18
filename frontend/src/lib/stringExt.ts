export function splitFirstOccurrence(inputString: string, separator: string): string[] {
    const index = inputString.indexOf(separator);

    if (index !== -1) {
        const firstPart = inputString.substring(0, index);
        const secondPart = inputString.substring(index + separator.length);
        return [firstPart, secondPart];
    }

    return [inputString];
}