class LocalStorageService {
    get = key => localStorage.getItem(key);

    set = (key, data) => {
        localStorage.setItem(key, data);
    };

    remove = key => {
        localStorage.removeItem(key);
    };
}

export default new LocalStorageService();
