import axios from "axios";

const api = axios.create({
    baseURL: "http://localhost:8000/api",
    headers: {
        "X-API-KEY": "tesProjectMiniUnggulSolusi"
    }
});

export default api;