import localStorageService from "./localStorageService";

class AuthStorage {
    setSession = (token) => {
        localStorageService.set('auth-token', token);
    };

    getSession = () => localStorageService.get('auth-token');

    deleteSession = () => {
        localStorageService.remove('auth-token');
    };
}

export default new AuthStorage();
