import store from '../shared/store';
import TokenUtil from './utils/token-util';
export default function () {
    //Before response
    axios.defaults.baseURL = 'https://blogger-community.herokuapp.com/api';
    axios.interceptors.request.use(request => {
        store.showLoader = true;
        if (TokenUtil.get()) {
            request.headers.common.Authorization = `Bearer ${TokenUtil.get()}`;
        }
        return request;
    });
    //After response
    axios.interceptors.response.use((response) => {
        store.showLoader = false;
        return response;
    }, (error) => {
        store.showLoader = false;
        return Promise.reject(error);
    })
}