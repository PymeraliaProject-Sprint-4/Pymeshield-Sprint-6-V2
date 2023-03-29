import axios from 'axios'

const api = axios.create({
            baseURL: import.meta.env.VITE_APP_URL_API,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Authorization': 'Bearer ' + document.querySelector('meta[name="token-bearer"]').getAttribute('content')
            },
            withCredentials: true
        })


export default api
