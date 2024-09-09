import axios from 'axios';

const baseApi = axios.create({
    baseURL: "https://host_testato.test/api/"
});
export default baseApi;
