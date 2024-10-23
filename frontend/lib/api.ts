// eslint-disable-next-line @typescript-eslint/ban-ts-comment
// @ts-nocheck
import Cookies from "js-cookie";
import {API_URL, TOKEN} from "@/lib/constant";
import toast from "react-hot-toast";

export { callApi };
const callApi = async (endpoint: string, method: string, data?: object|''|FormData) => {
    try {
        const token = Cookies.get(TOKEN);
        const headers: HeadersInit = {
            'Accept': 'application/json'
        };

        if (token) {
            headers['Authorization'] = `Bearer ${token}`;
        }
        const commonOptions: RequestInit = {method: method, headers: headers};

        const options: RequestInit = data instanceof FormData
            ? {...commonOptions, body: data}
            : {
                ...commonOptions,
                body: data !== undefined && data !== '' ? JSON.stringify(data) : undefined,
                headers: {...headers, 'Content-Type': 'application/json'}
            };

        const response = await fetch(API_URL + endpoint, options);

        if (response.status === 401) {
            Cookies.remove(TOKEN);
            window.location.href = "/";
            return;
        }

        const res = await response.json();

        if (res.errors) {
            const errors = res.errors ?? [];

            // Loop through each property in the error object
            for (const key in errors) {
                if (errors.hasOwnProperty(key)) {
                    const messages = errors[key];
                    toast.error(messages);
                }
            }
        } else {
            if (response.status >= 200 && response.status < 300 && res.message) {
                toast.success(res.message);
            }
            if(response.status == 422) {
                if(res.message) toast.error(res.message);
            }
        }
        return res;
    } catch (error) {
        console.log('An error occurred while processing your request:', error);
        throw new Error('An error occurred while processing your request: ' + error);
    }
};

export default callApi;
