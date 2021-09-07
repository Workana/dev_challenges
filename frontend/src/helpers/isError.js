export const isError = code => {
    const digit = parseInt(code?.toString()[0], 10);
    if (digit === 4 || digit === 5) {
        return true;
    }
    return false;
};
